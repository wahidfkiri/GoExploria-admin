<?php

namespace Vendor\Activities\Support;

use App\Models\Continent;
use App\Models\MapCategory;
use App\Models\MapPoint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Carte MONDIALE injectée dans une page composée dans l'éditeur.
 *
 * Extrait de LandingPageController le 2026-10-01, sans rien changer à la
 * logique : la page d'une CATÉGORIE d'activités porte la même section
 * d'attente `data-gx-map` que celle d'une activité, et les deux doivent
 * recevoir la même carte. Le contrôleur des activités délègue désormais ici.
 *
 * Par défaut la carte montre TOUS les points. Depuis le 2026-10-08, l'onglet
 * « Géo Maps Vidéos » des espaces activité et catégorie (admin) la règle par
 * propriétaire : `injecter($html, 'activity'|'category', $id)` lit
 * map_espace_reglages (carte masquée, points montrés, en-tête) et les points
 * dont map_points.activity_id / category_id vaut $id. Sans propriétaire, ou
 * sans réglage, le rendu est celui d'avant.
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
    public static function injecter(string $html, ?string $type = null, ?int $id = null): string
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
            $reglage = self::reglage($type, $id);

            // Carte désactivée dans l'onglet « Géo Maps Vidéos » : la section
            // disparaît, carton d'attente compris.
            if (!$reglage['maps_enabled']) {
                return preg_replace_callback($motif, fn () => '', $html, 1);
            }

            $contexte = self::contexte($type, $id, $reglage);

            // « Uniquement mes points » sans aucun point : rien à montrer. Une
            // carte vide irait de plus chercher ceux du monde entier (le moteur
            // recharge par l'API quand la page ne lui en donne aucun).
            if ($contexte === null) {
                return preg_replace_callback($motif, fn () => '', $html, 1);
            }

            $carte = view(self::partiel($html), $contexte)->render();
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
    private static function contexte(?string $type = null, ?int $id = null, ?array $reglage = null): ?array
    {
        $reglage ??= self::reglage($type, $id);
        $requete = fn () => MapPoint::with(['details', 'images', 'mainImage'])
            ->active()
            ->inDisplayPeriod()
            ->orderBy('is_featured', 'desc')
            ->orderBy('views', 'desc')
            ->limit(self::CARTE_LIMITE_POINTS);

        // Points du propriétaire (onglet « Géo Maps Vidéos » de l'espace
        // activité ou catégorie, colonnes map_points.activity_id/category_id).
        $colonne = self::COLONNES[$type] ?? null;
        $propres = collect();
        if ($colonne && $id && $reglage['points_source'] !== 'tous') {
            try {
                $propres = $requete()->where($colonne, $id)->get();
            } catch (\Throwable $e) {
                // Colonne absente tant que la migration de l'admin n'a pas
                // tourné : on retombe sur la carte mondiale.
                $propres = collect();
            }
        }

        if ($reglage['points_source'] === 'propres' && $propres->isEmpty()) {
            return null;
        }

        $restreinte = $propres->isNotEmpty();
        $points = $restreinte ? $propres : $requete()->get();

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
            // ⚠ Pas de filtre sur une carte RESTREINTE aux points du
            // propriétaire : chaque choix recharge les points de la
            // destination par l'API, donc ceux de tout le monde.
            'typeLabels' => self::LIBELLES_NIVEAUX,
            'mapFilterChain' => $restreinte ? [] : self::chaineFiltreDestinations(),
            // Carte restreinte : cadrée sur ses points plutôt que sur le monde.
            'fitToPoints' => $restreinte,
            'carteEntete' => self::entete($reglage['section_config'], $restreinte),
        ];
    }

    /** Colonne de map_points désignant chaque propriétaire « espace ». */
    private const COLONNES = [
        'activity' => 'activity_id',
        'category' => 'category_id',
    ];

    /**
     * Réglages de la carte d'une activité ou d'une catégorie, écrits par
     * l'onglet « Géo Maps Vidéos » de l'admin (table map_espace_reglages).
     *
     * Pas de propriétaire, pas de ligne ou table absente : carte affichée,
     * points automatiques, en-tête du gabarit — le rendu d'avant l'onglet.
     */
    private static function reglage(?string $type, ?int $id): array
    {
        $defaut = ['maps_enabled' => true, 'points_source' => 'auto', 'section_config' => null];

        if (!isset(self::COLONNES[$type]) || !$id) {
            return $defaut;
        }

        try {
            $ligne = DB::table('map_espace_reglages')
                ->where('owner_type', $type)
                ->where('owner_id', $id)
                ->first();
        } catch (\Throwable $e) {
            return $defaut;
        }

        if (!$ligne) {
            return $defaut;
        }

        $config = is_string($ligne->section_config) ? json_decode($ligne->section_config, true) : null;

        return [
            'maps_enabled' => (bool) $ligne->maps_enabled,
            'points_source' => in_array($ligne->points_source, ['auto', 'propres', 'tous'], true)
                ? $ligne->points_source
                : 'auto',
            'section_config' => is_array($config) ? $config : null,
        ];
    }

    /**
     * En-tête de la section : titre, phrase d'accroche, logo.
     *
     * Les couleurs ne sont imposées que si l'admin a coché « Couleurs
     * personnalisées » : sinon celles du gabarit s'appliquent. Sans phrase
     * réglée, l'accroche reste la phrase automatique (nombre de lieux).
     */
    private static function entete(?array $config, bool $restreinte): array
    {
        $config = $config ?: [];
        $couleur = fn ($v) => is_string($v) && preg_match('/^#[0-9a-fA-F]{6}$/', $v) ? $v : null;
        $perso = !empty($config['custom_colors']);
        $position = in_array($config['logo_position'] ?? null, ['left', 'center', 'right'], true)
            ? $config['logo_position']
            : 'center';
        $logo = trim((string) ($config['logo_path'] ?? ''));

        return [
            'titre' => trim((string) ($config['title'] ?? '')) ?: 'La carte des points d’intérêt',
            'accroche' => trim((string) ($config['subtitle'] ?? '')) ?: null,
            'couleur_titre' => $perso ? $couleur($config['title_color'] ?? null) : null,
            'couleur_accroche' => $perso ? $couleur($config['subtitle_color'] ?? null) : null,
            'logo' => !empty($config['show_logo']) && $logo !== '' ? $logo : null,
            'logo_position' => $position,
            'logo_taille' => max(32, min(320, (int) ($config['logo_size'] ?? 96))),
            // La phrase automatique dit « dans le monde » pour la carte
            // mondiale seulement.
            'monde' => !$restreinte,
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
