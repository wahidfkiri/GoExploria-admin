<?php

namespace Vendor\TravelDestination\Support;

use App\Models\Arrondissement;
use App\Models\Continent;
use App\Models\Country;
use App\Models\Province;
use App\Models\Quartier;
use App\Models\Region;
use App\Models\Secteur;
use App\Models\Ville;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Vendor\TravelDestination\Controllers\TravelDestinationController;

/**
 * Niveaux du fil d'Ariane HORS page de destination (accueil).
 *
 * Sur une page de destination, les niveaux viennent de
 * TravelDestinationController@buildBreadcrumbLevels : ils suivent la chaîne de
 * la destination affichée.
 *
 * Hors de ces pages, deux fils cohabitent :
 *   · `defaut()` — celui de l'accueil : une destination est posée d'office
 *     (Amérique du Nord → Canada → Québec) et la chaîne est déroulée comme sur
 *     la page de cette destination ;
 *   · `racine()` — le repli, quand cette destination manque. Aucune
 *     destination n'est alors choisie : la navigation part du niveau le plus
 *     large — SEUL le premier niveau qui compte des destinations actives (le
 *     continent, en pratique) ouvre sa liste.
 * Les niveaux suivants restent affichés, verrouillés : proposer les milliers de
 * villes avant d'avoir choisi un continent n'aiderait personne, et l'ordre de
 * lecture du fil le dit déjà — on descend un niveau après l'autre.
 *
 * La liste du premier niveau est plafonnée et le résultat est mis en cache :
 * ces requêtes seraient refaites à chaque affichage de l'accueil.
 */
class FilArianeDestinations
{
    /** Ordre d'affichage, du plus large au plus fin. */
    private const NIVEAUX = [
        'continent'      => [Continent::class, 'Continent'],
        'country'        => [Country::class, 'Pays'],
        'province'       => [Province::class, 'Province'],
        'region'         => [Region::class, 'Région'],
        'secteur'        => [Secteur::class, 'Secteur'],
        'city'           => [Ville::class, 'Ville'],
        'arrondissement' => [Arrondissement::class, 'Arrondissement'],
        'quartier'       => [Quartier::class, 'Quartier'],
    ];

    /**
     * Destination posée d'office quand la page n'en désigne aucune.
     * Pour en viser une autre, déclarer `travel_destination.fil_defaut`
     * dans la configuration : ['type' => 'province', 'slug' => 'ontario'].
     */
    private const DEFAUT = ['type' => 'province', 'slug' => 'quebec'];

    /** Types acceptables comme destination par défaut. */
    private const MODELES_DEFAUT = [
        'continent' => Continent::class,
        'country'   => Country::class,
        'province'  => Province::class,
        'region'    => Region::class,
        'secteur'   => Secteur::class,
        'city'      => Ville::class,
    ];

    /**
     * Fil affiché hors page de destination, chaîne déjà déroulée :
     * Amérique du Nord → Canada → Québec.
     *
     * Sans destination choisie, `racine()` n'ouvrait que les continents et
     * laissait tous les niveaux suivants verrouillés — le visiteur devait
     * redescendre la hiérarchie à chaque visite. Le public du site part du
     * Québec : la chaîne y est donc posée d'emblée, telle qu'elle s'afficherait
     * sur la page de la province (mêmes listes de frères à chaque niveau,
     * mêmes niveaux inférieurs ouverts).
     *
     * ⚠ Repli sur `racine()` dès que cette destination manque, est désactivée
     * ou que la base ne répond pas : l'accueil doit s'afficher dans tous les
     * cas, au pire avec l'ancien fil.
     */
    public static function defaut(int $minutes = 10): array
    {
        try {
            $niveaux = self::calculerDefaut($minutes);
        } catch (\Throwable $e) {
            $niveaux = [];
        }

        return $niveaux ?: self::racine();
    }

    private static function calculerDefaut(int $minutes): array
    {
        $cible  = config('travel_destination.fil_defaut') ?: self::DEFAUT;
        $type   = (string) ($cible['type'] ?? '');
        $slug   = (string) ($cible['slug'] ?? '');
        $modele = self::MODELES_DEFAUT[$type] ?? null;

        if (! $modele || $slug === '' || ! Route::has('travel-destination.show')) {
            return [];
        }

        $cle = 'travel-destination.fil-defaut.v1.' . $type . '.' . $slug;
        $enCache = Cache::get($cle);
        if (is_array($enCache) && $enCache !== []) {
            return $enCache;
        }

        $entite = self::trouverActive($modele, $slug);
        if (! $entite) {
            return [];
        }

        /* La chaîne est construite par le constructeur des pages de
           destination. Recopier ici sa logique — parents, frères, niveaux
           inférieurs — ferait deux versions à tenir à jour, et le fil de
           l'accueil finirait par diverger de celui des pages. */
        $niveaux = app(TravelDestinationController::class)
            ->buildBreadcrumbLevels($entite);

        /* ⚠ On ne met en cache QUE le succès. `Cache::remember` enregistrait
           aussi le tableau vide : un échec passager — base injoignable le
           temps d'un déploiement, données pas encore en place — figeait le
           repli pour toute la durée du cache, alors que l'appel suivant
           aurait réussi. */
        if ($niveaux !== []) {
            Cache::put($cle, $niveaux, $minutes * 60);
        }

        return $niveaux;
    }

    /**
     * Destination active portant ce slug.
     *
     * Trois tentatives, de la moins coûteuse à la plus sûre. Le slug est vide
     * en base pour plusieurs niveaux (voir `calculer()`), et le nom porte des
     * accents que le slug a perdus (« Québec » → quebec) :
     *   1. le slug tel quel ;
     *   2. le slug rendu en texte (tirets → espaces), comparé au nom — les
     *      collations par défaut de MySQL ignorent accents et casse, ce qui
     *      règle le cas courant en une requête ;
     *   3. à défaut, parcours par lots en comparant le nom normalisé. Accents
     *      et collations ne jouent plus, et la mémoire reste bornée.
     *
     * ⚠ La version précédente s'arrêtait aux 500 premières lignes actives
     * classées par nom. Au-delà de 500 destinations à un niveau — c'est le cas
     * des provinces du monde entier — une destination en fin d'alphabet, comme
     * Québec, tombait hors de la fenêtre et n'était jamais trouvée. Ce parcours
     * n'a lieu qu'au remplissage du cache, pas à chaque affichage.
     */
    private static function trouverActive(string $modele, string $slug)
    {
        $entite = self::requeteActive($modele)->where('slug', $slug)->first();
        if ($entite) {
            return $entite;
        }

        $nom = trim(str_replace('-', ' ', $slug));
        if ($nom === '') {
            return null;
        }

        $entite = self::requeteActive($modele)->where('name', 'like', $nom)->first();
        if ($entite) {
            return $entite;
        }

        $trouvee = null;
        self::requeteActive($modele)->orderBy('id')->chunk(500, function ($lot) use ($slug, &$trouvee) {
            foreach ($lot as $candidate) {
                if (Str::slug((string) ($candidate->name ?? '')) === $slug) {
                    $trouvee = $candidate;

                    return false;   // trouvée : inutile de lire la suite
                }
            }

            return true;
        });

        return $trouvee;
    }

    /**
     * ⚠ Jamais d'exception vers la page : le fil est un confort de navigation,
     * l'accueil doit s'afficher sans lui. Le cache lui-même peut échouer — il
     * passe par la base — d'où l'enveloppe autour de TOUT l'appel.
     */
    public static function racine(int $plafond = 60, int $minutes = 10): array
    {
        try {
            return self::calculer($plafond, $minutes);
        } catch (\Throwable $e) {
            return [];
        }
    }

    private static function calculer(int $plafond, int $minutes): array
    {
        return Cache::remember('travel-destination.fil-racine.v2.' . $plafond, $minutes * 60, function () use ($plafond) {
            if (! Route::has('travel-destination.show')) {
                return [];
            }

            $niveaux = [];
            $ouvert = false;   // le premier niveau peuplé est le seul à s'ouvrir

            foreach (self::NIVEAUX as $type => [$modele, $libelle]) {
                try {
                    $requete = self::requeteActive($modele);

                    /* Les niveaux verrouillés n'affichent aucune liste : inutile
                       d'en charger les lignes, savoir qu'ils existent suffit. */
                    if ($ouvert) {
                        if (! $requete->exists()) {
                            continue;
                        }

                        $niveaux[] = [
                            'type'       => $type,
                            'label'      => $libelle,
                            'url'        => null,
                            'courant'    => false,
                            'suivant'    => true,
                            'verrouille' => true,
                            'tronque'    => false,
                            'options'    => [],
                        ];

                        continue;
                    }

                    $entites = $requete->orderBy('name')->limit($plafond + 1)->get();
                } catch (\Throwable $e) {
                    continue;   // table absente ou modèle inattendu : on saute le niveau
                }

                if ($entites->isEmpty()) {
                    continue;   // niveau sans destination active : rien à proposer
                }

                $ouvert = true;

                $niveaux[] = [
                    'type'       => $type,
                    'label'      => $libelle,
                    'url'        => null,
                    'courant'    => false,
                    'suivant'    => true,
                    'verrouille' => false,
                    'tronque'    => $entites->count() > $plafond,
                    'options'    => $entites->take($plafond)->map(fn ($e) => [
                        'label'  => $e->name,
                        'url'    => route('travel-destination.show', [
                            'type' => $type,
                            // Le slug est vide en base pour plusieurs niveaux ;
                            // le site sait résoudre un nom normalisé.
                            'slug' => trim((string) ($e->slug ?? '')) !== ''
                                ? $e->slug
                                : \Illuminate\Support\Str::slug((string) $e->name),
                        ], false),
                        'actuel' => false,
                    ])->values()->all(),
                ];
            }

            return $niveaux;
        });
    }

    /** `active()` quand le modèle l'expose, sinon la colonne. */
    private static function requeteActive(string $modele)
    {
        try {
            return $modele::query()->active();
        } catch (\Throwable $e) {
            return $modele::query()->where('is_active', true);
        }
    }
}
