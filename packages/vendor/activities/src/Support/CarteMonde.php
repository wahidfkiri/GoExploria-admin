<?php

namespace Vendor\Activities\Support;

use App\Models\Continent;
use App\Models\MapCategory;
use App\Models\MapPoint;
use Illuminate\Support\Facades\Log;

/**
 * Carte MONDIALE injectée dans une page composée dans l'éditeur.
 *
 * Extrait de LandingPageController le 2026-10-01, sans rien changer à la
 * logique : la page d'une CATÉGORIE d'activités porte la même section
 * d'attente `data-gx-map` que celle d'une activité, et les deux doivent
 * recevoir la même carte. Le contrôleur des activités délègue désormais ici.
 *
 * ⚠ Rien dans ce dispositif ne dépend de l'entité affichée : la carte montre
 * TOUS les points, et le partiel world-map n'utilise pas la variable
 * `activity` qu'on lui passait. D'où un point d'entrée statique sans
 * paramètre d'entité.
 */
class CarteMonde
{
    /**
     * Nombre maximal de points envoyés avec la page.
     *
     * Ils partent dans le HTML (pas en AJAX) pour que la carte s'affiche dès
     * le premier rendu ; au-delà, la page deviendrait lourde.
     */
    private const CARTE_LIMITE_POINTS = 500;

    /**
     * Remplace la section d'attente `data-gx-map` par la vraie carte.
     *
     * Même dispositif que WebThemeController::injectLandingMap pour les sites
     * d'établissement : le contenu enregistré ne porte qu'un carton, sinon
     * l'éditeur VvvebJS chargerait Leaflet dans son canvas et enregistrerait
     * en base les tuiles, les marqueurs et les classes d'état à chaque
     * sauvegarde (docs/TEMPLATES-CMS.md §5).
     *
     * Une page sans section d'attente est rendue telle quelle : les pages
     * composées avant l'ajout de la carte continuent de fonctionner.
     */
    public static function injecter(string $html): string
    {
        if ($html === '') {
            return $html;
        }

        // La section d'attente n'est jamais imbriquée : le motif s'arrête au
        // premier </section>, ce que le gabarit garantit.
        $motif = '#<section[^>]*data-gx-map[^>]*>.*?</section>#is';

        if (!preg_match($motif, $html)) {
            return $html;
        }

        try {
            $carte = view(self::partiel($html), self::contexte())->render();
        } catch (\Throwable $e) {
            // Une carte en panne ne doit pas emporter la page : le carton
            // d'attente reste affiché.
            Log::warning("Carte mondiale : " . $e->getMessage());

            return $html;
        }

        // preg_replace lirait les `$` du partial comme des références
        // arrière : on passe par un rappel.
        return preg_replace_callback($motif, fn () => $carte, $html, 1);
    }

    /**
     * L'habillage à poser, choisi d'après le gabarit de la page d'accueil.
     *
     * Un seul MOTEUR, deux balisages : celui de `world-map` épouse le gabarit
     * PLEXIFY (classes `content-inner`, `container`, `section-head style-10`,
     * fournies par sa feuille). Une page BOUSSOLE ne charge pas ces classes —
     * la section sortait alors sans mise en page : boutons de filtre bruts et
     * `#travel-map` sans hauteur, donc aucune carte visible.
     *
     * ⚠ La feuille vendor/activities/css/activity-map.css habille les DEUX
     * racines (`:is(.actpage-tpl, .boussole-tpl)`) : c'est elle qui donne sa
     * hauteur au conteneur de la carte. La re-scoper au seul Plexify
     * reproduirait exactement ce défaut.
     */
    protected static function partiel(string $html): string
    {
        return str_contains($html, 'boussole-tpl')
            ? 'activities::landing.partials.world-map-boussole'
            : 'activities::landing.partials.world-map';
    }

    /**
     * Contexte d'une carte MONDIALE, montrant TOUS les points.
     *
     * Le moteur est celui des pages de destination ; on lui présente le monde
     * comme un « continent » sans coordonnées, ce qu'il rend en vue globale
     * (centre [20, 0], zoom 2). Aucune restriction géographique n'est posée
     * sur les points, et `visibleOn` n'est pas appliqué : une page d'activité
     * n'est pas un niveau de destination, et la demande est bien d'afficher
     * tous les points.
     */
    private static function contexte(): array
    {
        $points = MapPoint::with(['details', 'images', 'mainImage'])
            ->active()
            ->inDisplayPeriod()
            ->orderBy('is_featured', 'desc')
            ->orderBy('views', 'desc')
            ->limit(self::CARTE_LIMITE_POINTS)
            ->get();

        // Le monde, vu par le moteur de carte. Sans latitude, il se cadre sur
        // la vue globale — exactement ce qu'on veut ici.
        $monde = (object) [
            'id' => 0,
            'name' => 'Le monde',
            'latitude' => null,
            'longitude' => null,
        ];

        // Adresse de rechargement des points, utilisée par le filtre par
        // destination. Le continent porteur doit être ACTIF : l'endpoint
        // `map-points` ne résout que les destinations actives et répondrait
        // « Entity not found » sur un continent désactivé. Sans filtre, la
        // réponse au niveau « continent » n'est bornée par aucune géographie,
        // quel que soit le continent visé.
        $slug = (string) (Continent::active()->orderBy('id')->value('code')
            ?: Continent::active()->orderBy('id')->value('id')
            ?: 'monde');

        return [
            'entity' => $monde,
            'normalizedType' => 'continent',
            'slug' => $slug,
            // Pas de niveau inférieur à proposer : le sélecteur de zoom du
            // moteur reste masqué (il se garde sur childEntities.length).
            'childEntities' => collect(),
            'mapCategories' => MapCategory::where('is_active', true)
                ->orderBy('sort_order')
                ->get(['slug', 'name', 'icon_class', 'color', 'image']),
            'mapPoints' => $points,
            // Filtre par destination : la page couvre le monde, la cascade
            // part donc du continent (voir chaineFiltreDestinations).
            'typeLabels' => self::LIBELLES_NIVEAUX,
            'mapFilterChain' => self::chaineFiltreDestinations(),
        ];
    }

    /**
     * Libellés des niveaux de destination, repris du contrôleur des pages de
     * destination : le filtre les affiche au-dessus de chaque champ.
     */
    private const LIBELLES_NIVEAUX = [
        'continent' => 'Continent',
        'country' => 'Pays',
        'province' => 'Province',
        'region' => 'Région',
        'city' => 'Ville',
        'secteur' => 'Secteur',
        'arrondissement' => 'Arrondissement',
        'quartier' => 'Quartier',
    ];

    /**
     * Premier niveau du filtre par destination de la carte mondiale.
     *
     * Sur une page de destination la chaîne commence sous la destination
     * courante ; ici la carte couvre le monde, le premier champ interrogeable
     * est donc celui des CONTINENTS. Les niveaux suivants (pays, province,
     * région…) sont chargés en cascade par le filtre lui-même, via l'endpoint
     * `travel-destination.children` — rien à préparer pour eux.
     *
     * La table `continents` ne porte pas de coordonnées : le centre d'un
     * continent est calculé depuis ses pays, faute de quoi la carte ne saurait
     * pas où se recentrer et l'option serait donnée pour « sans coordonnées ».
     * Les pays INACTIFS comptent dans ce calcul — il s'agit de cadrer une vue,
     * pas de publier une liste, et l'Amérique du Nord ne s'arrête pas à la
     * frontière canadienne sous prétexte que seul le Canada est publié.
     */
    private static function chaineFiltreDestinations(): array
    {
        $continents = Continent::active()
            ->with('countries')
            ->orderBy('name')
            ->get();

        $options = $continents
            ->map(function (Continent $continent) {
                // `countries.latitude` est une colonne texte : on convertit
                // avant toute comparaison, sans quoi le minimum se jouerait
                // entre chaînes de caractères.
                $reperes = $continent->countries
                    ->filter(fn ($pays) => is_numeric($pays->latitude) && is_numeric($pays->longitude))
                    ->map(fn ($pays) => ['lat' => (float) $pays->latitude, 'lng' => (float) $pays->longitude]);

                // Centre de l'enveloppe des pays : plus stable qu'une moyenne,
                // qu'un pays isolé (une île lointaine) suffirait à décentrer.
                $lat = $reperes->count() ? (($reperes->min('lat') + $reperes->max('lat')) / 2) : null;
                $lng = $reperes->count() ? (($reperes->min('lng') + $reperes->max('lng')) / 2) : null;

                return [
                    'name' => $continent->name,
                    'slug' => (string) ($continent->slug ?? $continent->id),
                    'type' => 'continent',
                    'latitude' => $lat,
                    'longitude' => $lng,
                    // Même échelle que formatFilterOptions() côté destinations.
                    'zoom' => 3,
                ];
            })
            ->values()
            ->all();

        if (!$options) {
            return [];
        }

        return [[
            'type' => 'continent',
            'label' => self::LIBELLES_NIVEAUX['continent'],
            'fixed' => false,
            'current' => null,
            'options' => $options,
        ]];
    }
}
