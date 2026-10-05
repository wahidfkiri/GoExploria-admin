<?php

namespace Vendor\TravelDestination\Support;

use App\Models\Activity;
use App\Models\Arrondissement;
use App\Models\Continent;
use App\Models\Country;
use App\Models\Province;
use App\Models\Quartier;
use App\Models\Region;
use App\Models\Secteur;
use App\Models\Ville;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Activités d'une destination ET DE TOUTE SA DESCENDANCE, groupées par
 * destination puis par catégorie, avec leurs visuels.
 *
 * Alimente le méga-menu ouvert par le bouton « Voir les activités » de la
 * bannière, sur toutes les pages de destination — la page composée dans
 * l'éditeur (gabarit « Carnet d'Atlas ») comme la page classique.
 *
 * ─────────────────────────────────────────────────────────────────────────
 * CE QU'IL RAMÈNE  (étendu le 2026-10-05)
 * ─────────────────────────────────────────────────────────────────────────
 * 1. Les activités rattachées à la destination AFFICHÉE ;
 * 2. puis celles de CHACUNE de ses destinations descendantes, à tous les
 *    niveaux inférieurs et non plus seulement au niveau juste en dessous.
 *    Sur le Canada, le menu montre donc les activités du pays, de ses
 *    provinces, de leurs régions, de leurs secteurs et villes, et jusqu'aux
 *    arrondissements et quartiers.
 *
 * Dans chaque groupe, les activités sont rangées par catégorie. La
 * destination, la catégorie et l'activité portent chacune son visuel quand
 * elle en a un (colonnes `image`, et `icon` pour une catégorie).
 *
 * ─────────────────────────────────────────────────────────────────────────
 * COMBIEN DE REQUÊTES
 * ─────────────────────────────────────────────────────────────────────────
 * La descente est faite NIVEAU PAR NIVEAU, jamais destination par
 * destination : une requête pour les destinations d'un niveau, une pour son
 * pivot, puis UNE SEULE pour toutes les activités trouvées. Soit au plus
 * ~2 × 8 + 1 requêtes, quel que soit le nombre de destinations — la version
 * précédente en faisait une par destination enfant.
 *
 * ⚠ Le rattachement passe par un pivot PAR NIVEAU (`activity_continent`,
 * `activity_country`, … et `activity_city` pour les villes — la seule qui ne
 * suit pas le nom de sa table). Côté administration, la table de
 * correspondance fait foi : Vendor\Destination\Support\ActivitesDestination.
 *
 * ⚠ Les pivots des trois derniers niveaux (secteur, arrondissement,
 * quartier) n'existent que depuis la migration du 2026-09-30. Tout est donc
 * gardé : un niveau sans pivot est simplement sauté, le menu montre les
 * autres.
 */
class ActivitesParDestination
{
    /**
     * Les huit niveaux, du plus large au plus fin.
     *
     * Pour chacun : le modèle, le pivot des activités et sa colonne, le
     * segment d'URL du site, le libellé affiché, et ses enfants directs
     * `[modèle, colonne parente, niveau]`.
     *
     * ⚠ Une région a DEUX descendances (ses secteurs ET ses villes, une
     * ville pouvant pendre directement d'elle) : les deux sont parcourues,
     * et les doublons écartés par identifiant.
     *
     * ⚠ Le site nomme les villes « city » dans ses URL ; la table dit
     * `villes` et le pivot `activity_city` / `ville_id`.
     */
    protected const NIVEAUX = [
        'continent' => [
            'modele'  => Continent::class,
            'pivot'   => ['activity_continent', 'continent_id'],
            'segment' => 'continent',
            'libelle' => 'Continent',
            'enfants' => [[Country::class, 'continent_id', 'country']],
        ],
        'country' => [
            'modele'  => Country::class,
            'pivot'   => ['activity_country', 'country_id'],
            'segment' => 'country',
            'libelle' => 'Pays',
            'enfants' => [[Province::class, 'country_id', 'province']],
        ],
        'province' => [
            'modele'  => Province::class,
            'pivot'   => ['activity_province', 'province_id'],
            'segment' => 'province',
            'libelle' => 'Province',
            'enfants' => [[Region::class, 'province_id', 'region']],
        ],
        'region' => [
            'modele'  => Region::class,
            'pivot'   => ['activity_region', 'region_id'],
            'segment' => 'region',
            'libelle' => 'Région',
            'enfants' => [
                [Secteur::class, 'region_id', 'secteur'],
                [Ville::class, 'region_id', 'ville'],
            ],
        ],
        'secteur' => [
            'modele'  => Secteur::class,
            'pivot'   => ['activity_secteur', 'secteur_id'],
            'segment' => 'secteur',
            'libelle' => 'Secteur',
            'enfants' => [[Ville::class, 'secteur_id', 'ville']],
        ],
        'ville' => [
            'modele'  => Ville::class,
            'pivot'   => ['activity_city', 'ville_id'],
            'segment' => 'city',
            'libelle' => 'Ville',
            'enfants' => [[Arrondissement::class, 'ville_id', 'arrondissement']],
        ],
        'arrondissement' => [
            'modele'  => Arrondissement::class,
            'pivot'   => ['activity_arrondissement', 'arrondissement_id'],
            'segment' => 'arrondissement',
            'libelle' => 'Arrondissement',
            'enfants' => [[Quartier::class, 'arrondissement_id', 'quartier']],
        ],
        'quartier' => [
            'modele'  => Quartier::class,
            'pivot'   => ['activity_quartier', 'quartier_id'],
            'segment' => 'quartier',
            'libelle' => 'Quartier',
            'enfants' => [],
        ],
    ];

    /** Destinations ramenées par niveau : un continent peut avoir beaucoup de villes. */
    protected const PLAFOND_PAR_NIVEAU = 400;

    /** Groupes affichés : au-delà, le menu devient illisible. */
    protected const PLAFOND_GROUPES = 40;

    /** Activités chargées en tout, toutes destinations confondues. */
    protected const PLAFOND_ACTIVITES = 900;

    /**
     * @return array{total:int, groupes:array<int, array<string, mixed>>}
     */
    public static function pour($entity, string $type): array
    {
        $niveau = static::niveauDe($type, $entity);

        if ($niveau === null || ! is_object($entity)) {
            return ['total' => 0, 'groupes' => []];
        }

        // 1. La destination affichée, puis toute sa descendance, niveau par
        //    niveau. L'ordre du tableau est celui de l'affichage.
        $descendance = static::descendance($entity, $niveau);

        // 2. Les liens destination → activités, un pivot par niveau.
        $liens = [];      // "niveau#id" => [id d'activité, …]
        $idsActivites = [];

        foreach ($descendance as $cleNiveau => $destinations) {
            foreach (static::liensDuNiveau($cleNiveau, $destinations->pluck('id')->all()) as $id => $ids) {
                $liens[$cleNiveau . '#' . $id] = $ids;
                $idsActivites = array_merge($idsActivites, $ids);
            }
        }

        $idsActivites = array_slice(array_values(array_unique($idsActivites)), 0, static::PLAFOND_ACTIVITES);

        if ($idsActivites === []) {
            return ['total' => 0, 'groupes' => []];
        }

        // 3. Toutes les activités en UNE requête.
        $activites = static::activites($idsActivites);

        // 4. Les groupes, dans l'ordre de la descendance.
        $groupes = [];
        $total = 0;

        foreach ($descendance as $cleNiveau => $destinations) {
            foreach ($destinations as $destination) {
                $siennes = collect($liens[$cleNiveau . '#' . $destination->id] ?? [])
                    ->map(fn ($id) => $activites->get($id))
                    ->filter()
                    ->values();

                if ($siennes->isEmpty()) {
                    continue;
                }

                $total += $siennes->count();
                $groupes[] = static::groupe($destination, $cleNiveau, $siennes, $destination->is($entity));

                if (count($groupes) >= static::PLAFOND_GROUPES) {
                    break 2;
                }
            }
        }

        return ['total' => $total, 'groupes' => $groupes];
    }

    /** Niveau interne d'une destination : le type passé, sinon sa classe. */
    protected static function niveauDe(string $type, $entity): ?string
    {
        $type = $type === 'city' ? 'ville' : $type;

        if (isset(static::NIVEAUX[$type])) {
            return $type;
        }

        foreach (static::NIVEAUX as $cle => $niveau) {
            if (is_object($entity) && $entity instanceof $niveau['modele']) {
                return $cle;
            }
        }

        return null;
    }

    /**
     * La destination affichée, puis TOUTES ses destinations descendantes,
     * rangées par niveau, du plus large au plus fin.
     *
     * Une seule requête par niveau : les enfants sont demandés pour tous les
     * parents à la fois.
     *
     * @return array<string, Collection>
     */
    protected static function descendance($entity, string $niveau): array
    {
        $parNiveau = [$niveau => collect([$entity])];
        $atteint = false;

        foreach (static::NIVEAUX as $cle => $definition) {
            // Les niveaux au-dessus de la destination affichée sont ignorés :
            // le menu descend, il ne remonte pas.
            $atteint = $atteint || $cle === $niveau;

            if (! $atteint || empty($parNiveau[$cle])) {
                continue;
            }

            $parents = $parNiveau[$cle]->pluck('id')->filter()->all();

            if ($parents === []) {
                continue;
            }

            foreach ($definition['enfants'] as [$modele, $colonne, $niveauEnfant]) {
                $trouves = static::enfants($modele, $colonne, $parents);

                if ($trouves->isEmpty()) {
                    continue;
                }

                $parNiveau[$niveauEnfant] = isset($parNiveau[$niveauEnfant])
                    ? $parNiveau[$niveauEnfant]->merge($trouves)->unique('id')->values()
                    : $trouves;
            }
        }

        return $parNiveau;
    }

    /** Enfants actifs d'un lot de parents, bornés et triés par nom. */
    protected static function enfants(string $modele, string $colonne, array $parents): Collection
    {
        $construire = function (bool $colonnesChoisies) use ($modele, $colonne, $parents) {
            $requete = $modele::query()->whereIn($colonne, $parents);

            // `active()` n'existe pas sur tous les modèles : on l'utilise si
            // elle est là.
            if (method_exists($modele, 'scopeActive')) {
                $requete->active();
            }

            // Seules quatre colonnes servent au menu. Les tables de
            // destinations portent de longs textes (description, histoire,
            // économie…) : les charger pour des centaines de lignes à chaque
            // niveau coûterait plusieurs mégaoctets pour rien.
            if ($colonnesChoisies) {
                $requete->select(['id', 'name', 'code', 'image']);
            }

            return $requete->orderBy('name')->limit(static::PLAFOND_PAR_NIVEAU)->get();
        };

        try {
            return $construire(true);
        } catch (\Throwable $e) {
            // ⚠ Une installation à qui il manquerait l'une de ces colonnes
            // ferait échouer la requête : on réessaie sans restriction plutôt
            // que de perdre tout un niveau du menu.
            try {
                return $construire(false);
            } catch (\Throwable $ignore) {
                // Le second échec ne dit rien de plus que le premier.
            }

            Log::warning(static::class . ' : descendance indisponible — ' . $e->getMessage(), [
                'modele' => $modele, 'colonne' => $colonne,
            ]);

            return collect();
        }
    }

    /**
     * Liens d'un niveau, lus directement dans sa table pivot.
     *
     * Passer par le pivot plutôt que par la relation `activities()` du
     * modèle évite une requête par destination, et fonctionne même sur un
     * niveau dont le modèle ne porte pas la relation.
     *
     * @param  int[]  $ids
     * @return array<int, int[]>  identifiant de destination => identifiants d'activités
     */
    protected static function liensDuNiveau(string $niveau, array $ids): array
    {
        if ($ids === [] || ! isset(static::NIVEAUX[$niveau])) {
            return [];
        }

        [$pivot, $colonne] = static::NIVEAUX[$niveau]['pivot'];

        try {
            $lignes = DB::table($pivot)->whereIn($colonne, $ids)->get([$colonne, 'activity_id']);
        } catch (\Throwable $e) {
            // Pivot absent sur une installation partielle : ce niveau est
            // sauté, les autres restent affichés.
            Log::warning(static::class . ' : pivot indisponible — ' . $e->getMessage(), [
                'niveau' => $niveau, 'pivot' => $pivot,
            ]);

            return [];
        }

        $liens = [];

        foreach ($lignes as $ligne) {
            $liens[(int) $ligne->{$colonne}][] = (int) $ligne->activity_id;
        }

        return $liens;
    }

    /**
     * Les activités actives et publiables, indexées par identifiant.
     *
     * ⚠ Une activité sans slug n'a pas de page : elle est écartée, sinon le
     * menu offrirait un lien vers `/activity/`.
     */
    protected static function activites(array $ids): Collection
    {
        try {
            return Activity::query()
                ->whereIn('id', $ids)
                ->where('is_active', true)
                ->with('categoryRelation:id,name,slug,icon')
                ->orderBy('name')
                ->get()
                ->filter(fn ($a) => trim((string) $a->slug) !== '')
                ->keyBy('id');
        } catch (\Throwable $e) {
            Log::warning(static::class . ' : activités indisponibles — ' . $e->getMessage());

            return collect();
        }
    }

    /**
     * Un groupe : la destination, son visuel, puis ses activités rangées par
     * catégorie.
     */
    protected static function groupe($destination, string $niveau, Collection $activites, bool $courante): array
    {
        $categories = $activites
            ->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)
            ->groupBy(fn ($a) => $a->categoryRelation->id ?? 0)
            ->map(function (Collection $items, $id) {
                $categorie = $id ? $items->first()->categoryRelation : null;
                $visuel = static::visuelCategorie($categorie);

                return [
                    'nom' => $categorie->name ?? 'Autres activités',
                    'lien' => static::lienCategorie($categorie),
                    'image' => $visuel['image'],
                    'icone' => $visuel['icone'],
                    'activites' => $items->map(fn ($a) => [
                        'nom' => (string) $a->name,
                        'url' => '/activity/' . $a->slug,
                        'image' => static::media($a->image ?? null),
                    ])->values()->all(),
                ];
            })
            // « Autres activités » en dernier, le reste par ordre alphabétique.
            ->sortBy(fn (array $g) => ($g['nom'] === 'Autres activités' ? '~' : '') . mb_strtolower($g['nom']))
            ->values()
            ->all();

        return [
            'nom' => (string) $destination->name,
            'url' => static::lienDestination($destination, $niveau),
            'image' => static::media($destination->image ?? null),
            'niveau' => static::NIVEAUX[$niveau]['libelle'] ?? 'Destination',
            'courante' => $courante,
            'nombre' => $activites->count(),
            'categories' => $categories,
        ];
    }

    /**
     * Adresse d'un visuel enregistré.
     *
     * ⚠ La colonne ne contient pas toujours la même chose : les écrans
     * d'administration des continents et des pays y écrivent une adresse
     * complète (`asset('storage/…')`), l'espace destination un simple chemin
     * relatif au disque public. Les deux formes sont donc acceptées, comme
     * le fait déjà `Activity::getImageUrlAttribute()`.
     */
    protected static function media($valeur): ?string
    {
        $valeur = trim((string) ($valeur ?? ''));

        if ($valeur === '') {
            return null;
        }

        if (Str::startsWith($valeur, ['http://', 'https://', '//', '/'])) {
            return $valeur;
        }

        return asset('storage/' . ltrim($valeur, '/'));
    }

    /**
     * Visuel d'une catégorie : sa colonne `icon` porte SOIT un fichier, SOIT
     * une classe Font Awesome (`fa-solid fa-person-hiking`). On ne devine pas
     * à partir du contenu une image qui n'en est pas : seule une valeur qui
     * ressemble à un chemin est traitée comme telle.
     *
     * @return array{image: ?string, icone: ?string}
     */
    protected static function visuelCategorie($categorie): array
    {
        $valeur = trim((string) ($categorie->icon ?? ''));

        if ($valeur === '') {
            return ['image' => null, 'icone' => null];
        }

        $ressembleAUnFichier = Str::contains($valeur, ['/', '\\'])
            || (bool) preg_match('/\.(png|jpe?g|gif|webp|avif|svg)$/i', $valeur);

        return $ressembleAUnFichier
            ? ['image' => static::media($valeur), 'icone' => null]
            : ['image' => null, 'icone' => $valeur];
    }

    /**
     * Page publique d'une destination : /travel-destination/{segment}/{code}.
     *
     * L'identifiant est le `code` quand il existe — c'est ce que résout
     * DestinationService, qui retombe sur l'id pour une valeur numérique.
     */
    protected static function lienDestination($destination, string $niveau): ?string
    {
        $segment = static::NIVEAUX[$niveau]['segment'] ?? null;

        if ($segment === null) {
            return null;
        }

        $identifiant = trim((string) ($destination->code ?? '')) ?: (string) $destination->id;

        return $identifiant === ''
            ? null
            : '/travel-destination/' . $segment . '/' . rawurlencode($identifiant);
    }

    /** Page publique d'une catégorie : /categories/{slug}. */
    protected static function lienCategorie($categorie): ?string
    {
        if (! $categorie) {
            return null;
        }

        $identifiant = trim((string) ($categorie->slug ?? '')) ?: (string) ($categorie->id ?? '');

        return $identifiant === '' ? null : '/categories/' . rawurlencode($identifiant);
    }
}
