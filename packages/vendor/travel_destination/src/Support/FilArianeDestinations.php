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

/**
 * Niveaux du fil d'Ariane HORS page de destination (accueil).
 *
 * Sur une page de destination, les niveaux viennent de
 * TravelDestinationController@buildBreadcrumbLevels : ils suivent la chaîne de
 * la destination affichée. À l'accueil, aucune destination n'est choisie : la
 * navigation part donc du niveau le plus large — SEUL le premier niveau qui
 * compte des destinations actives (le continent, en pratique) ouvre sa liste.
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
