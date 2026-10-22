<?php

namespace Vendor\Cms\Contenus;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use RuntimeException;
use Throwable;
use Vendor\Cms\Models\ContenuRevision;
use Vendor\Cms\Models\ContenuStockage;
use Vendor\Cms\Models\EtablissementTemplate;
use Vendor\Cms\Models\HeaderFooter;
use Vendor\Cms\Models\Page;

/**
 * Où vivent les contenus d'un PROPRIÉTAIRE — établissement, activité,
 * catégorie, destination (cf. Proprietaires) : en base (historique) ou dans
 * le dépôt de fichiers. Source unique, utilisée par le trait StockeEnFichiers
 * (lecture/écriture transparentes sur les modèles), par la commande
 * `contenus:basculer` et par les cartes « Stockage des contenus ».
 *
 * Règles :
 *  - pas de ligne contenu_stockages = mode « base » : rien ne change ;
 *  - en mode « fichiers », la révision la plus récente d'un champ fait foi ;
 *    la colonne garde la copie d'avant la bascule (filet de sécurité) tant
 *    que la base n'a pas été « libérée » ;
 *  - revenir en base réécrit d'abord les colonnes depuis les fichiers : on
 *    peut changer d'avis à tout moment sans rien perdre.
 *
 * ⚠ Les lignes de contenu ne sont pas toutes sur la même connexion : les
 * tables du CMS sont sur « cms », `pages` (destinations) et `page_contents`
 * (activités, catégories) sur la connexion principale. Chaque écriture
 * passe par la connexion du modèle ; les révisions, elles, sont sur « cms ».
 *
 * Enregistré en `scoped` : ses caches vivent le temps d'une requête (Octane
 * compris), jamais d'une requête à l'autre.
 */
class StockageContenus
{
    /** Modèles concernés et leurs champs de contenu. */
    public const RESSOURCES = [
        Page::class => ['content'],
        HeaderFooter::class => ['content', 'html_content', 'css_content'],
        EtablissementTemplate::class => ['page_contents'],
        // Destinations (8 niveaux) : la page du site et les pages libres.
        'App\\Models\\Page' => ['html_content', 'css_content'],
        // Activités et catégories : la page composée et les contenus typés.
        'App\\Models\\PageContent' => ['content'],
    ];

    protected ?bool $tablesPresentes = null;

    /** @var array<string, string> mode par « classe#id » */
    protected array $modes = [];

    /** @var array<string, array<string, ContenuRevision>> révision courante par clé, par propriétaire */
    protected array $revisions = [];

    /** @var array<int, ?string> valeur recomposée par identifiant de révision */
    protected array $valeurs = [];

    public function __construct(protected DepotContenus $depot)
    {
    }

    public static function instance(): self
    {
        return app(self::class);
    }

    public function depot(): DepotContenus
    {
        return $this->depot;
    }

    /** Tables absentes (migration pas encore passée) = tout reste en base. */
    public function tablesPresentes(): bool
    {
        if ($this->tablesPresentes === null) {
            try {
                $schema = Schema::connection('cms');
                $this->tablesPresentes = $schema->hasTable('contenu_stockages')
                    && $schema->hasTable('contenu_revisions')
                    && $schema->hasColumn('contenu_stockages', 'proprietaire_type');
            } catch (Throwable) {
                $this->tablesPresentes = false;
            }
        }

        return $this->tablesPresentes;
    }

    public function mode(?string $type, ?int $id): string
    {
        if (! $type || ! $id || ! $this->tablesPresentes()) {
            return ContenuStockage::BASE;
        }

        return $this->modes[$this->cleProprietaire($type, $id)] ??=
            (ContenuStockage::where('proprietaire_type', $type)->where('proprietaire_id', $id)->value('mode')
                ?: ContenuStockage::BASE);
    }

    public function enFichiers(?string $type, ?int $id): bool
    {
        return $this->mode($type, $id) === ContenuStockage::FICHIERS;
    }

    public function etablissementEnFichiers(int $etablissementId): bool
    {
        return $this->enFichiers(Proprietaires::ETABLISSEMENT, $etablissementId);
    }

    /** Les classes de RESSOURCES réellement chargées dans ce projet. */
    public static function ressources(): array
    {
        return array_filter(self::RESSOURCES, fn ($champs, $classe) => class_exists($classe), ARRAY_FILTER_USE_BOTH);
    }

    /* ------------------------------------------------------------------
     | Lecture / écriture d'un champ (appelées par le trait)
     * ------------------------------------------------------------------ */

    /**
     * @return array{0: bool, 1: ?string} [trouvé dans les fichiers, valeur]
     */
    public function lireChamp(Model $modele, string $champ): array
    {
        [$type, $id] = $modele->proprietaireContenus() ?? [null, null];

        if (! $modele->exists || ! $this->enFichiers($type, $id)) {
            return [false, null];
        }

        $revision = $this->revisionsDe($type, $id)[$this->cle($modele->getTable(), $modele->getKey(), $champ)] ?? null;

        if ($revision === null) {
            return [false, null];
        }

        try {
            return [true, $this->valeurRevision($revision)];
        } catch (Throwable $e) {
            // Objet manquant ou altéré : on retombe sur la colonne (copie
            // d'avant la bascule) plutôt que de casser la page.
            Log::error('Contenu en fichiers illisible : ' . $e->getMessage(), ['revision' => $revision->id]);

            return [false, null];
        }
    }

    public function valeurRevision(ContenuRevision $revision): ?string
    {
        if (array_key_exists($revision->id, $this->valeurs)) {
            return $this->valeurs[$revision->id];
        }

        if ($revision->manifeste === null) {
            return $this->valeurs[$revision->id] = null;
        }

        $valeur = $this->recomposer($revision->manifeste);

        if ($revision->empreinte && DepotContenus::empreinte($valeur) !== $revision->empreinte) {
            throw new RuntimeException("Révision {$revision->id} : le contenu relu ne correspond pas à son empreinte.");
        }

        return $this->valeurs[$revision->id] = $valeur;
    }

    /**
     * Dépose les objets d'une valeur (AVANT l'écriture en base : un échec
     * du dépôt annule l'enregistrement) et rend de quoi créer la révision.
     *
     * @return array{manifeste: ?array, empreinte: ?string, taille: int}
     */
    public function preparer(?string $valeur): array
    {
        if ($valeur === null) {
            return ['manifeste' => null, 'empreinte' => null, 'taille' => 0];
        }

        $manifeste = [];

        foreach (Decoupeur::decouper($valeur) as $segment) {
            $element = ['t' => $segment['t'], 'h' => $this->depot->deposer($segment['contenu'], $segment['t'])];

            if ($segment['t'] === 'css') {
                $element['o'] = $segment['o'];
                $element['f'] = $segment['f'];
            }

            $manifeste[] = $element;
        }

        return ['manifeste' => $manifeste, 'empreinte' => DepotContenus::empreinte($valeur), 'taille' => strlen($valeur)];
    }

    /** Crée la révision (sauf si la valeur n'a pas changé) et élague l'historique. */
    public function enregistrer(Model $modele, string $champ, array $prepare, string $origine, ?int $auteurId = null): ?ContenuRevision
    {
        $proprietaire = $modele->proprietaireContenus();

        if ($proprietaire === null) {
            return null;
        }

        [$type, $id] = $proprietaire;
        $cle = $this->cle($modele->getTable(), $modele->getKey(), $champ);
        $actuelle = $this->revisionsDe($type, $id)[$cle] ?? null;

        if ($actuelle !== null
            && $actuelle->empreinte === $prepare['empreinte']
            && ($actuelle->manifeste === null) === ($prepare['manifeste'] === null)) {
            return $actuelle;
        }

        $revision = ContenuRevision::create([
            'proprietaire_type' => $type,
            'proprietaire_id' => $id,
            'etablissement_id' => $type === Proprietaires::ETABLISSEMENT ? $id : null,
            'ressource_type' => $modele->getTable(),
            'ressource_id' => $modele->getKey(),
            'champ' => $champ,
            'manifeste' => $prepare['manifeste'],
            'empreinte' => $prepare['empreinte'],
            'taille' => $prepare['taille'],
            'origine' => $origine,
            'auteur_id' => $auteurId,
        ]);

        $this->revisions[$this->cleProprietaire($type, $id)][$cle] = $revision;
        $this->elaguer($revision);

        return $revision;
    }

    /* ------------------------------------------------------------------
     | Changements de mode
     * ------------------------------------------------------------------ */

    /** Copie tous les contenus du propriétaire dans le dépôt, vérifie, puis bascule. */
    public function basculerVersFichiers(string $type, int $id, bool $simulation = false, ?int $auteurId = null): array
    {
        $this->exigerTables();

        $rapport = ['proprietaire' => Proprietaires::reference($type, $id), 'mode_avant' => $this->mode($type, $id),
            'lignes' => 0, 'champs' => 0, 'octets_base' => 0, 'objets' => [], 'simulation' => $simulation];

        $traiter = function () use ($type, $id, $simulation, $auteurId, &$rapport) {
            foreach (self::ressources() as $classe => $champs) {
                $requete = $this->requete($classe, $type, $id);
                if ($requete === null) {
                    continue;
                }

                $requete->chunkById(50, function ($lignes) use ($champs, $simulation, $auteurId, &$rapport) {
                    foreach ($lignes as $ligne) {
                        $rapport['lignes']++;

                        foreach ($champs as $champ) {
                            if (! array_key_exists($champ, $ligne->getAttributes())) {
                                continue;
                            }

                            $brut = $ligne->getRawOriginal($champ);
                            if ($brut === null) {
                                continue;
                            }

                            $brut = (string) $brut;
                            $rapport['champs']++;
                            $rapport['octets_base'] += strlen($brut);

                            foreach (Decoupeur::decouper($brut) as $segment) {
                                $rapport['objets'][$segment['t'] . ':' . DepotContenus::empreinte($segment['contenu'])] = strlen($segment['contenu']);
                            }

                            if ($simulation) {
                                continue;
                            }

                            $prepare = $this->preparer($brut);

                            // Relecture depuis le disque : on ne bascule que ce
                            // qu'on sait rendre à l'octet près.
                            if ($this->recomposer($prepare['manifeste']) !== $brut) {
                                throw new RuntimeException("Relecture différente : {$ligne->getTable()} #{$ligne->getKey()} ({$champ}).");
                            }

                            $this->enregistrer($ligne, $champ, $prepare, 'bascule', $auteurId);
                        }
                    }
                });
            }

            if (! $simulation) {
                ContenuStockage::updateOrCreate(
                    ['proprietaire_type' => $type, 'proprietaire_id' => $id],
                    ['etablissement_id' => $type === Proprietaires::ETABLISSEMENT ? $id : null,
                        'mode' => ContenuStockage::FICHIERS, 'bascule_le' => now(), 'base_liberee_le' => null, 'modifie_par' => $auteurId]
                );
                $this->modes[$this->cleProprietaire($type, $id)] = ContenuStockage::FICHIERS;
            }
        };

        $simulation ? $traiter() : DB::connection('cms')->transaction($traiter);

        return $this->conclure($rapport);
    }

    /** Réécrit les colonnes depuis les fichiers, puis repasse en mode « base ». */
    public function revenirEnBase(string $type, int $id, bool $simulation = false, ?int $auteurId = null): array
    {
        $this->exigerTables();

        $rapport = ['proprietaire' => Proprietaires::reference($type, $id), 'mode_avant' => $this->mode($type, $id),
            'champs' => 0, 'simulation' => $simulation];

        if ($rapport['mode_avant'] !== ContenuStockage::FICHIERS) {
            return $rapport + ['message' => 'Déjà en mode « base ».'];
        }

        $revisions = $this->revisionsDe($type, $id);
        // Tout relire AVANT d'écrire : un objet manquant arrête tout, rien n'est écrit.
        $valeurs = array_map(fn (ContenuRevision $r) => $this->valeurRevision($r), $revisions);

        if ($simulation) {
            return ['champs' => count($valeurs)] + $rapport;
        }

        DB::connection('cms')->transaction(function () use ($type, $id, $revisions, $valeurs, $auteurId, &$rapport) {
            foreach ($revisions as $cle => $revision) {
                $rapport['champs'] += $this->tableDe($revision->ressource_type)
                    ->where('id', $revision->ressource_id)
                    ->update([$revision->champ => $valeurs[$cle]]);
            }

            ContenuStockage::updateOrCreate(
                ['proprietaire_type' => $type, 'proprietaire_id' => $id],
                ['mode' => ContenuStockage::BASE, 'base_liberee_le' => null, 'modifie_par' => $auteurId]
            );
            $this->modes[$this->cleProprietaire($type, $id)] = ContenuStockage::BASE;
        });

        return $rapport;
    }

    /**
     * Vide les colonnes de contenu (mode « fichiers » seulement), après avoir
     * vérifié que chaque révision se relit. C'est ce qui libère réellement
     * l'espace en base ; « revenir en base » les réécrit.
     */
    public function libererBase(string $type, int $id, bool $simulation = false): array
    {
        $this->exigerTables();

        if (! $this->enFichiers($type, $id)) {
            throw new RuntimeException("Libérer la base n'est possible qu'en mode « fichiers ».");
        }

        $revisions = $this->revisionsDe($type, $id);
        foreach ($revisions as $revision) {
            $this->valeurRevision($revision); // lève une exception si un objet manque
        }

        $rapport = ['proprietaire' => Proprietaires::reference($type, $id), 'octets_liberes' => $this->octetsEnBase($type, $id),
            'champs' => count($revisions), 'simulation' => $simulation];

        if ($simulation) {
            return $rapport;
        }

        DB::connection('cms')->transaction(function () use ($type, $id, $revisions) {
            foreach ($revisions as $revision) {
                $this->tableDe($revision->ressource_type)
                    ->where('id', $revision->ressource_id)
                    ->update([$revision->champ => null]);
            }

            ContenuStockage::where('proprietaire_type', $type)->where('proprietaire_id', $id)
                ->update(['base_liberee_le' => now()]);
        });

        return $rapport;
    }

    /** Résumé affiché par les cartes « Stockage des contenus » et par la commande. */
    public function etat(string $type, int $id): array
    {
        if (! $this->tablesPresentes()) {
            return ['disponible' => false, 'mode' => ContenuStockage::BASE];
        }

        $ligne = ContenuStockage::where('proprietaire_type', $type)->where('proprietaire_id', $id)->first();
        $objets = [];

        foreach ($this->revisionsDe($type, $id) as $revision) {
            foreach ((array) $revision->manifeste as $segment) {
                $chemin = $this->depot->chemin($segment['h'], $segment['t']);
                $objets[$chemin] = is_file($chemin) ? filesize($chemin) : 0;
            }
        }

        return [
            'disponible' => true,
            'proprietaire' => Proprietaires::reference($type, $id),
            'mode' => $ligne->mode ?? ContenuStockage::BASE,
            'bascule_le' => $ligne?->bascule_le,
            'base_liberee_le' => $ligne?->base_liberee_le,
            'octets_base' => $this->octetsEnBase($type, $id),
            'octets_fichiers' => array_sum($objets),
            'objets' => count($objets),
            'revisions' => count($this->revisionsDe($type, $id)),
            'depot' => $this->depot->etat(),
        ];
    }

    public function octetsEnBase(string $type, int $id): int
    {
        $total = 0;

        foreach (self::ressources() as $classe => $champs) {
            $requete = $this->requete($classe, $type, $id);
            if ($requete === null) {
                continue;
            }

            $modele = $requete->getModel();
            $schema = Schema::connection($modele->getConnectionName());
            $champs = array_values(array_filter($champs, fn ($c) => $schema->hasColumn($modele->getTable(), $c)));

            if ($champs === []) {
                continue;
            }

            $somme = implode(' + ', array_map(fn ($c) => "COALESCE(LENGTH({$c}), 0)", $champs));
            $total += (int) $requete->toBase()->selectRaw("SUM({$somme}) AS total")->value('total');
        }

        return $total;
    }

    /* ------------------------------------------------------------------ */

    /**
     * Requête des lignes d'une classe pour un propriétaire (suppressions
     * douces comprises : elles occupent de la place), ou null si la classe
     * ne concerne pas ce type de propriétaire.
     */
    protected function requete(string $classe, string $type, int $id)
    {
        if (! $this->tableExiste($classe)) {
            return null; // table absente de cette installation : rien à y ranger
        }

        $requete = $classe::query();

        if (in_array(SoftDeletes::class, class_uses_recursive($classe), true)) {
            $requete->withTrashed();
        }

        return $classe::filtrerParProprietaireContenus($requete, $type, $id);
    }

    /** @var array<string, bool> */
    protected array $tables = [];

    protected function tableExiste(string $classe): bool
    {
        if (! array_key_exists($classe, $this->tables)) {
            $modele = new $classe;

            try {
                $this->tables[$classe] = Schema::connection($modele->getConnectionName())->hasTable($modele->getTable());
            } catch (Throwable) {
                $this->tables[$classe] = false;
            }
        }

        return $this->tables[$classe];
    }

    /** @return array<string, ContenuRevision> */
    protected function revisionsDe(?string $type, ?int $id): array
    {
        if (! $type || ! $id || ! $this->tablesPresentes()) {
            return [];
        }

        return $this->revisions[$this->cleProprietaire($type, $id)] ??= ContenuRevision::query()
            ->where('proprietaire_type', $type)
            ->where('proprietaire_id', $id)
            ->whereIn('id', function ($requete) use ($type, $id) {
                $requete->from('contenu_revisions')
                    ->selectRaw('MAX(id)')
                    ->where('proprietaire_type', $type)
                    ->where('proprietaire_id', $id)
                    ->groupBy('ressource_type', 'ressource_id', 'champ');
            })
            ->get()
            ->keyBy(fn (ContenuRevision $r) => $this->cle($r->ressource_type, $r->ressource_id, $r->champ))
            ->all();
    }

    protected function recomposer(array $manifeste): string
    {
        return Decoupeur::recomposer(array_map(
            fn (array $segment) => $segment + ['contenu' => $this->depot->lire($segment['h'], $segment['t'])],
            $manifeste
        ));
    }

    protected function elaguer(ContenuRevision $revision): void
    {
        $anciennes = ContenuRevision::where('proprietaire_type', $revision->proprietaire_type)
            ->where('proprietaire_id', $revision->proprietaire_id)
            ->where('ressource_type', $revision->ressource_type)
            ->where('ressource_id', $revision->ressource_id)
            ->where('champ', $revision->champ)
            ->orderByDesc('id')
            ->skip(max(1, (int) config('cms.contenus.revisions', 20)))
            ->take(1000)
            ->pluck('id');

        if ($anciennes->isNotEmpty()) {
            ContenuRevision::whereIn('id', $anciennes)->delete();
        }
    }

    protected function cle(string $table, $id, string $champ): string
    {
        return $table . ':' . $id . ':' . $champ;
    }

    protected function cleProprietaire(string $type, int $id): string
    {
        return $type . '#' . $id;
    }

    /** Écriture brute sur une table de contenu, par la connexion de SON modèle. */
    protected function tableDe(string $table)
    {
        foreach (array_keys(self::ressources()) as $classe) {
            $modele = new $classe;

            if ($modele->getTable() === $table) {
                return DB::connection($modele->getConnectionName())->table($table);
            }
        }

        throw new RuntimeException("Table de contenu inattendue : {$table}");
    }

    protected function exigerTables(): void
    {
        if (! $this->tablesPresentes()) {
            throw new RuntimeException('Tables contenu_stockages / contenu_revisions absentes ou anciennes : lancer les migrations du paquet CMS (2026_10_21_000001 puis 2026_10_22_000001).');
        }
    }

    protected function conclure(array $rapport): array
    {
        $rapport['objets_distincts'] = count($rapport['objets']);
        $rapport['octets_fichiers'] = array_sum($rapport['objets']);
        unset($rapport['objets']);

        return $rapport;
    }
}
