<?php

namespace Vendor\Cms\Contenus;

use Illuminate\Database\Eloquent\Model;
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
 * Où vivent les contenus d'un établissement : en base (historique) ou dans
 * le dépôt de fichiers. Source unique, utilisée par le trait StockeEnFichiers
 * (lecture/écriture transparentes sur les modèles), par la commande
 * `contenus:basculer` et par la carte « Stockage des contenus » de l'onglet
 * Configuration.
 *
 * Règles :
 *  - pas de ligne contenu_stockages = mode « base » : rien ne change ;
 *  - en mode « fichiers », la révision la plus récente d'un champ fait foi ;
 *    la colonne garde la copie d'avant la bascule (filet de sécurité) tant
 *    que la base n'a pas été « libérée » ;
 *  - revenir en base réécrit d'abord les colonnes depuis les fichiers : on
 *    peut changer d'avis à tout moment sans rien perdre.
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
    ];

    protected ?bool $tablesPresentes = null;

    /** @var array<int, string> */
    protected array $modes = [];

    /** @var array<int, array<string, ContenuRevision>> révision courante par clé */
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
                $this->tablesPresentes = $schema->hasTable('contenu_stockages') && $schema->hasTable('contenu_revisions');
            } catch (Throwable) {
                $this->tablesPresentes = false;
            }
        }

        return $this->tablesPresentes;
    }

    public function mode(?int $etablissementId): string
    {
        if (! $etablissementId || ! $this->tablesPresentes()) {
            return ContenuStockage::BASE;
        }

        return $this->modes[$etablissementId] ??=
            (ContenuStockage::where('etablissement_id', $etablissementId)->value('mode') ?: ContenuStockage::BASE);
    }

    public function enFichiers(?int $etablissementId): bool
    {
        return $this->mode($etablissementId) === ContenuStockage::FICHIERS;
    }

    /* ------------------------------------------------------------------
     | Lecture / écriture d'un champ (appelées par le trait)
     * ------------------------------------------------------------------ */

    /**
     * @return array{0: bool, 1: ?string} [trouvé dans les fichiers, valeur]
     */
    public function lireChamp(Model $modele, string $champ): array
    {
        $etablissementId = (int) $modele->getAttribute('etablissement_id');

        if (! $modele->exists || ! $this->enFichiers($etablissementId)) {
            return [false, null];
        }

        $revision = $this->revisionsDe($etablissementId)[$this->cle($modele->getTable(), $modele->getKey(), $champ)] ?? null;

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
    public function enregistrer(Model $modele, string $champ, array $prepare, string $origine, ?int $auteurId = null): ContenuRevision
    {
        $etablissementId = (int) $modele->getAttribute('etablissement_id');
        $cle = $this->cle($modele->getTable(), $modele->getKey(), $champ);
        $actuelle = $this->revisionsDe($etablissementId)[$cle] ?? null;

        if ($actuelle !== null
            && $actuelle->empreinte === $prepare['empreinte']
            && ($actuelle->manifeste === null) === ($prepare['manifeste'] === null)) {
            return $actuelle;
        }

        $revision = ContenuRevision::create([
            'etablissement_id' => $etablissementId,
            'ressource_type' => $modele->getTable(),
            'ressource_id' => $modele->getKey(),
            'champ' => $champ,
            'manifeste' => $prepare['manifeste'],
            'empreinte' => $prepare['empreinte'],
            'taille' => $prepare['taille'],
            'origine' => $origine,
            'auteur_id' => $auteurId,
        ]);

        $this->revisions[$etablissementId][$cle] = $revision;
        $this->elaguer($revision);

        return $revision;
    }

    /* ------------------------------------------------------------------
     | Changements de mode
     * ------------------------------------------------------------------ */

    /** Copie tous les contenus de l'établissement dans le dépôt, vérifie, puis bascule. */
    public function basculerVersFichiers(int $etablissementId, bool $simulation = false, ?int $auteurId = null): array
    {
        $this->exigerTables();

        $rapport = ['mode_avant' => $this->mode($etablissementId), 'lignes' => 0, 'champs' => 0,
            'octets_base' => 0, 'objets' => [], 'simulation' => $simulation];

        $traiter = function () use ($etablissementId, $simulation, $auteurId, &$rapport) {
            foreach (self::RESSOURCES as $classe => $champs) {
                $classe::withTrashed()->where('etablissement_id', $etablissementId)
                    ->chunkById(50, function ($lignes) use ($champs, $simulation, $auteurId, &$rapport) {
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
                    ['etablissement_id' => $etablissementId],
                    ['mode' => ContenuStockage::FICHIERS, 'bascule_le' => now(), 'base_liberee_le' => null, 'modifie_par' => $auteurId]
                );
                $this->modes[$etablissementId] = ContenuStockage::FICHIERS;
            }
        };

        $simulation ? $traiter() : DB::connection('cms')->transaction($traiter);

        return $this->conclure($rapport);
    }

    /** Réécrit les colonnes depuis les fichiers, puis repasse en mode « base ». */
    public function revenirEnBase(int $etablissementId, bool $simulation = false, ?int $auteurId = null): array
    {
        $this->exigerTables();

        $rapport = ['mode_avant' => $this->mode($etablissementId), 'champs' => 0, 'simulation' => $simulation];

        if ($rapport['mode_avant'] !== ContenuStockage::FICHIERS) {
            return $rapport + ['message' => "L'établissement est déjà en mode « base »."];
        }

        $revisions = $this->revisionsDe($etablissementId);
        // Tout relire AVANT d'écrire : un objet manquant arrête tout, rien n'est écrit.
        $valeurs = array_map(fn (ContenuRevision $r) => $this->valeurRevision($r), $revisions);

        if ($simulation) {
            return ['champs' => count($valeurs)] + $rapport;
        }

        DB::connection('cms')->transaction(function () use ($etablissementId, $revisions, $valeurs, $auteurId, &$rapport) {
            foreach ($revisions as $cle => $revision) {
                $rapport['champs'] += DB::connection('cms')->table($this->tableAutorisee($revision->ressource_type))
                    ->where('id', $revision->ressource_id)
                    ->update([$revision->champ => $valeurs[$cle]]);
            }

            ContenuStockage::updateOrCreate(
                ['etablissement_id' => $etablissementId],
                ['mode' => ContenuStockage::BASE, 'base_liberee_le' => null, 'modifie_par' => $auteurId]
            );
            $this->modes[$etablissementId] = ContenuStockage::BASE;
        });

        return $rapport;
    }

    /**
     * Vide les colonnes de contenu (mode « fichiers » seulement), après avoir
     * vérifié que chaque révision se relit. C'est ce qui libère réellement
     * l'espace en base ; « revenir en base » les réécrit.
     */
    public function libererBase(int $etablissementId, bool $simulation = false): array
    {
        $this->exigerTables();

        if (! $this->enFichiers($etablissementId)) {
            throw new RuntimeException("Libérer la base n'est possible qu'en mode « fichiers ».");
        }

        $revisions = $this->revisionsDe($etablissementId);
        foreach ($revisions as $revision) {
            $this->valeurRevision($revision); // lève une exception si un objet manque
        }

        $rapport = ['octets_liberes' => $this->octetsEnBase($etablissementId), 'champs' => count($revisions), 'simulation' => $simulation];

        if ($simulation) {
            return $rapport;
        }

        DB::connection('cms')->transaction(function () use ($etablissementId, $revisions) {
            foreach ($revisions as $revision) {
                DB::connection('cms')->table($this->tableAutorisee($revision->ressource_type))
                    ->where('id', $revision->ressource_id)
                    ->update([$revision->champ => null]);
            }

            ContenuStockage::where('etablissement_id', $etablissementId)->update(['base_liberee_le' => now()]);
        });

        return $rapport;
    }

    /** Résumé affiché par la carte de l'onglet Configuration et par la commande. */
    public function etat(int $etablissementId): array
    {
        if (! $this->tablesPresentes()) {
            return ['disponible' => false, 'mode' => ContenuStockage::BASE];
        }

        $ligne = ContenuStockage::where('etablissement_id', $etablissementId)->first();
        $objets = [];

        foreach ($this->revisionsDe($etablissementId) as $revision) {
            foreach ((array) $revision->manifeste as $segment) {
                $chemin = $this->depot->chemin($segment['h'], $segment['t']);
                $objets[$chemin] = is_file($chemin) ? filesize($chemin) : 0;
            }
        }

        return [
            'disponible' => true,
            'mode' => $ligne->mode ?? ContenuStockage::BASE,
            'bascule_le' => $ligne?->bascule_le,
            'base_liberee_le' => $ligne?->base_liberee_le,
            'octets_base' => $this->octetsEnBase($etablissementId),
            'octets_fichiers' => array_sum($objets),
            'objets' => count($objets),
            'revisions' => count($this->revisionsDe($etablissementId)),
            'depot' => $this->depot->etat(),
        ];
    }

    public function octetsEnBase(int $etablissementId): int
    {
        $total = 0;

        foreach (self::RESSOURCES as $classe => $champs) {
            $modele = new $classe;
            $schema = Schema::connection('cms');
            $champs = array_values(array_filter($champs, fn ($c) => $schema->hasColumn($modele->getTable(), $c)));

            if ($champs === []) {
                continue;
            }

            $somme = implode(' + ', array_map(fn ($c) => "COALESCE(LENGTH({$c}), 0)", $champs));
            $total += (int) DB::connection('cms')->table($modele->getTable())
                ->where('etablissement_id', $etablissementId)
                ->selectRaw("SUM({$somme}) AS total")
                ->value('total');
        }

        return $total;
    }

    /* ------------------------------------------------------------------ */

    /** @return array<string, ContenuRevision> */
    protected function revisionsDe(int $etablissementId): array
    {
        if (! $this->tablesPresentes()) {
            return [];
        }

        return $this->revisions[$etablissementId] ??= ContenuRevision::query()
            ->where('etablissement_id', $etablissementId)
            ->whereIn('id', function ($requete) use ($etablissementId) {
                $requete->from('contenu_revisions')
                    ->selectRaw('MAX(id)')
                    ->where('etablissement_id', $etablissementId)
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
        $anciennes = ContenuRevision::where('etablissement_id', $revision->etablissement_id)
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

    protected function tableAutorisee(string $table): string
    {
        $tables = array_map(fn ($classe) => (new $classe)->getTable(), array_keys(self::RESSOURCES));

        if (! in_array($table, $tables, true)) {
            throw new RuntimeException("Table de contenu inattendue : {$table}");
        }

        return $table;
    }

    protected function exigerTables(): void
    {
        if (! $this->tablesPresentes()) {
            throw new RuntimeException('Tables contenu_stockages / contenu_revisions absentes : lancer la migration du paquet CMS.');
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
