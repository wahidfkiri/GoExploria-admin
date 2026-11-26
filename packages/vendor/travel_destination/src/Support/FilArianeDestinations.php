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

        return Cache::remember(
            'travel-destination.fil-defaut.v1.' . $type . '.' . $slug,
            $minutes * 60,
            function () use ($modele, $slug) {
                $entite = self::trouverActive($modele, $slug);
                if (! $entite) {
                    return [];
                }

                /* La chaîne est construite par le constructeur des pages de
                   destination. Recopier ici sa logique — parents, frères,
                   niveaux inférieurs — ferait deux versions à tenir à jour, et
                   le fil de l'accueil finirait par diverger de celui des
                   pages. */
                return app(TravelDestinationController::class)
                    ->buildBreadcrumbLevels($entite);
            }
        );
    }

    /**
     * Destination active portant ce slug. Le slug est vide en base pour
     * plusieurs niveaux (voir `calculer()`) : à défaut, on compare au nom
     * normalisé, sur un échantillon borné pour ne pas balayer une grande table.
     */
    private static function trouverActive(string $modele, string $slug)
    {
        $entite = self::requeteActive($modele)->where('slug', $slug)->first();
        if ($entite) {
            return $entite;
        }

        return self::requeteActive($modele)->orderBy('name')->limit(500)->get()
            ->first(fn ($e) => Str::slug((string) ($e->name ?? '')) === $slug);
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
