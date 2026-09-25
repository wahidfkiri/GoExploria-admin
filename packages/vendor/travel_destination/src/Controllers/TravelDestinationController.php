<?php

namespace Vendor\TravelDestination\Controllers;

use App\Helpers\DestinationHelper;
use App\Models\MapCategory;
use App\Models\MapPoint;
use App\Models\PageContent;
use App\Models\Page;
use App\Services\DestinationService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Vendor\TravelDestination\Support\DestinationDefaultPage;

class TravelDestinationController extends Controller
{
    protected $typeMap = [
        'continent' => 'continent',
        'continents' => 'continent',
        'country' => 'country',
        'countries' => 'country',
        'province' => 'province',
        'provinces' => 'province',
        'region' => 'region',
        'regions' => 'region',
        'city' => 'city',
        'cities' => 'city',
        'secteur' => 'secteur',
        'secteurs' => 'secteur',
        'arrondissement' => 'arrondissement',
        'arrondissements' => 'arrondissement',
        'quartier' => 'quartier',
        'quartiers' => 'quartier',
    ];

    protected $typeModelMap = [
        'continent' => \App\Models\Continent::class,
        'country' => \App\Models\Country::class,
        'province' => \App\Models\Province::class,
        'region' => \App\Models\Region::class,
        'city' => \App\Models\Ville::class,
        'secteur' => \App\Models\Secteur::class,
        'arrondissement' => \App\Models\Arrondissement::class,
        'quartier' => \App\Models\Quartier::class,
    ];

    protected $typeLabels = [
        'continent' => 'Continent',
        'country' => 'Pays',
        'province' => 'Province',
        'region' => 'Région',
        'city' => 'Ville',
        'secteur' => 'Secteur',
        'arrondissement' => 'Arrondissement',
        'quartier' => 'Quartier',
    ];

    public function show($type, $slug)
    {
        $normalizedType = $this->typeMap[$type] ?? 'continent';
        $entity = $this->loadEntity($normalizedType, $slug);

        if (!$entity) {
            abort(404);
        }

        $breadcrumb = $this->buildBreadcrumb($normalizedType, $entity);
        $hierarchy = DestinationHelper::hierarchy(get_class($entity), $entity->id) ?? collect();
        $stats = $this->buildStats($normalizedType, $entity);

        $pageContents = PageContent::whereNull('activity_id')
            ->where('is_active', true)
            ->where('pageable_type', get_class($entity))
            ->where('pageable_id', $entity->id)
            ->orderBy('order')
            ->get()
            ->groupBy('type');

        $heroContents = $pageContents->get('hero', collect());
        $aboutContents = $pageContents->get('about', collect());
        $testimonials = $pageContents->get('testimonial', collect());
        $events = $pageContents->get('event', collect());
        $faqs = $pageContents->get('faq', collect());
        $blogs = $pageContents->get('blog', collect());
        $galleryItems = $pageContents->get('gallery', collect());
        $videos = $pageContents->get('video', collect());
        $contactInfo = $pageContents->get('contact', collect());
        $destinations = $pageContents->get('destination', collect());

        $childEntities = $this->getChildEntities($normalizedType, $entity);
        $heroSlide = $heroContents->first();
        $heroImage = $heroSlide?->image_url ?? $entity->image ?? null;
        $mapCategories = MapCategory::where('is_active', true)->orderBy('sort_order')->get(['slug', 'name', 'icon_class', 'color', 'image']);
        $destinationActivities = method_exists($entity, 'activities') ? $entity->activities()->where('is_active', true)->get() : collect();

        $mapPoints = collect();
        if (in_array($normalizedType, ['continent', 'country', 'province', 'region', 'city', 'secteur', 'arrondissement', 'quartier'])) {
            $radius = match ($normalizedType) {
                'continent' => 45,
                'country' => 10,
                'province' => 3.5,
                'region' => 1.5,
                'city' => 0.3,
                'secteur' => 0.15,
                'arrondissement' => 0.1,
                'quartier' => 0.05,
                default => 5,
            };
            $q = MapPoint::with(['details', 'images', 'mainImage'])->active()
                ->visibleOn($normalizedType)
                ->inDisplayPeriod();
            if ($normalizedType !== 'continent') {
                $childrenWithLat = $childEntities ? $childEntities->whereNotNull('latitude') : collect();
                if ($childrenWithLat->count() > 0) {
                    $padding = match ($normalizedType) {
                        'continent' => 2,
                        'country' => 1.5,
                        'province' => 1,
                        'region' => 0.5,
                        default => 0.3,
                    };
                    $q->whereBetween('latitude', [$childrenWithLat->min('latitude') - $padding, $childrenWithLat->max('latitude') + $padding])
                      ->whereBetween('longitude', [$childrenWithLat->min('longitude') - $padding, $childrenWithLat->max('longitude') + $padding]);
                } elseif ($entity->latitude && $entity->longitude) {
                    $q->whereBetween('latitude', [$entity->latitude - $radius, $entity->latitude + $radius])
                      ->whereBetween('longitude', [$entity->longitude - $radius, $entity->longitude + $radius]);
                }
            }
            $mapPoints = $q->orderBy('is_featured', 'desc')->orderBy('views', 'desc')->limit(500)->get();
        }

        $ads = DB::table('ads')
            ->where('status', 'active')
            ->where(function ($q) {
                $q->whereNull('start_date')->orWhere('start_date', '<=', now()->toDateString());
            })
            ->where(function ($q) {
                $q->whereNull('end_date')->orWhere('end_date', '>=', now()->toDateString());
            })
            ->where(function ($q) {
                $q->whereNull('budget_total')->orWhereRaw('budget_total > COALESCE(budget_spent, 0)');
            })
            ->orderBy('priority')
            ->orderByDesc('id')
            ->get();

        // LA page de destination (template « Carnet d'Atlas ») : toute
        // destination en possède une. Si l'administrateur ne l'a jamais
        // touchée, elle n'existe pas en base et c'est le gabarit qui est rendu ;
        // s'il l'a masquée, on n'affiche rien.
        $defaultPage = DestinationDefaultPage::resolve($entity);

        // Section « Établissements à proximité » : le gabarit ne porte que des
        // cartes de démonstration, remplacées ici par les établissements
        // situés dans cette destination — elle-même et tout ce qui pend en
        // dessous — et ses filtres par les catégories réellement présentes.
        // Sans établissement rattaché, la démonstration reste affichée.
        if (! empty($defaultPage['html'])) {
            // ⚠ L'ORDRE compte : la section est d'abord posée sur les pages
            // enregistrées avant son arrivée, puis hydratée. L'inverse
            // laisserait la section greffée avec ses cartes de démonstration.
            $defaultPage['html'] = \Vendor\Cms\Support\TemplateEtablissements::hydrateDestination(
                DestinationDefaultPage::avecEtablissements($defaultPage['html']),
                $normalizedType,
                (int) $entity->id
            );
        }

        // Chaîne de filtres de la carte, calquée sur le fil d'Ariane.
        $mapFilterChain = $this->buildMapFilterChain($normalizedType, $entity);

        // Pages composées dans l'éditeur visuel côté admin : leur HTML/CSS est
        // injecté tel quel sous les sections standard de la destination.
        $builderPages = Page::where('pageable_type', get_class($entity))
            ->where('pageable_id', $entity->id)
            ->where('is_active', true)
            ->where('is_default', false)
            ->orderBy('id')
            ->get();

        // Le template « Carnet d'Atlas » est le gabarit par défaut de toutes les
        // destinations. L'ancienne page reste accessible via ?template=classic
        // (repli le temps que le contenu de chaque destination soit repris).
        $view = request()->query('template') === 'classic'
            ? 'travel-destination::landing.classic'
            : 'travel-destination::landing.index';

        return view($view, compact(
            'entity',
            'normalizedType',
            'slug',
            'defaultPage',
            'mapFilterChain',
            'builderPages',
            'breadcrumb',
            'hierarchy',
            'stats',
            'heroContents',
            'heroSlide',
            'heroImage',
            'aboutContents',
            'testimonials',
            'events',
            'faqs',
            'blogs',
            'galleryItems',
            'videos',
            'contactInfo',
            'destinations',
            'childEntities',
            'mapCategories',
            'destinationActivities',
            'mapPoints',
            'ads'
        ));
    }

    /**
     * Enfants directs d'une destination, pour la cascade de filtres de la carte.
     *
     * Le filtre descend la chaîne un niveau à la fois : on ne précharge pas
     * l'arborescence entière (551 destinations, et les villes vont croître),
     * chaque niveau est demandé au moment où l'utilisateur ouvre son champ.
     */
    /**
     * Contenu du méga-menu « Activités » de l'en-tête des pages destination.
     *
     * Chargé à la première ouverture du menu, pas avec la page : il liste
     * TOUTES les activités actives (près d'un millier), soit plusieurs
     * centaines de Ko de HTML que la plupart des visiteurs n'ouvrent jamais.
     * Mis en cache 10 minutes ; la clé suit la date de la vue, pour qu'un
     * changement de gabarit soit visible sans vider le cache.
     */
    public function activitiesMenu()
    {
        $vue = 'travel-destination::landing.partials.activities-mega-menu-content';
        $cle = 'travel-destination.activities-menu.v2.' . (@filemtime(view()->getFinder()->find($vue)) ?: '0');

        $html = \Illuminate\Support\Facades\Cache::remember($cle, 600, fn () => $this->compacterHtml(view($vue)->render()));

        return response($html)
            ->header('Content-Type', 'text/html; charset=UTF-8')
            ->header('Cache-Control', 'public, max-age=600');
    }

    /**
     * Contenu du méga-menu « Destinations » de la barre latérale.
     *
     * Même principe que activitiesMenu : chargé à la première ouverture, mis
     * en cache 10 minutes, clé indexée sur la date de la vue.
     *
     * Rendu côté serveur plutôt que via /api/v1/destinations : cette API
     * répond par identifiant ET par slug selon les routes (provinces d'un
     * pays : vide avec le slug), et ne donne pas les URL du gabarit.
     */
    public function destinationsMenu()
    {
        $vue = 'travel-destination::landing.partials.destinations-menu-content';
        $cle = 'travel-destination.destinations-menu.v2.' . (@filemtime(view()->getFinder()->find($vue)) ?: '0');

        $html = \Illuminate\Support\Facades\Cache::remember($cle, 600, fn () => $this->compacterHtml(view($vue)->render()));

        return response($html)
            ->header('Content-Type', 'text/html; charset=UTF-8')
            ->header('Cache-Control', 'public, max-age=600');
    }

    /**
     * Retire l'indentation Blade ENTRE balises (« >   < » → « >< »).
     *
     * Le menu Activités pèse ~570 Ko, dont ~165 Ko d'espaces : autant de
     * moins à transférer, à analyser et à garder en cache. Le texte n'est pas
     * touché (seuls les blancs situés entre deux balises disparaissent) et les
     * blocs concernés sont en flex/grille, où ces blancs ne s'affichent pas.
     */
    protected function compacterHtml(string $html): string
    {
        return preg_replace('/>\s+</', '><', $html) ?? $html;
    }

    public function children($type, $slug)
    {
        $normalizedType = $this->typeMap[$type] ?? null;

        if ($normalizedType === null) {
            return response()->json(['success' => false, 'message' => 'Type inconnu'], 404);
        }

        $entity = $this->loadEntity($normalizedType, $slug);

        if (! $entity) {
            return response()->json(['success' => false, 'message' => 'Destination introuvable'], 404);
        }

        [$childType, $children] = $this->filterChildren($normalizedType, $entity);

        return response()->json([
            'success' => true,
            'type'    => $childType,
            'label'   => $childType ? ($this->typeLabels[$childType] ?? $childType) : null,
            'items'   => $this->formatFilterOptions($childType, $children),
        ]);
    }

    /**
     * Enfants d'une destination pour le filtre.
     *
     * Diffère de getChildEntities() sur un point : une région expose ses
     * SECTEURS quand elle en a (sinon ses villes). La chaîne du fil d'Ariane
     * comporte ce niveau, le filtre doit donc pouvoir s'y arrêter.
     *
     * @return array{0: ?string, 1: \Illuminate\Support\Collection}
     */
    protected function filterChildren($type, $entity): array
    {
        switch ($type) {
            case 'continent':
                return ['country', $entity->countries()->active()->get()];
            case 'country':
                return ['province', $entity->provinces()->active()->get()];
            case 'province':
                return ['region', $entity->regions()->active()->get()];
            case 'region':
                $secteurs = $entity->secteurs()->active()->get();
                return $secteurs->count() > 0
                    ? ['secteur', $secteurs]
                    : ['city', $entity->villes()->active()->get()];
            case 'secteur':
                return ['city', $entity->villes()->active()->get()];
            case 'city':
                return ['arrondissement', $entity->arrondissements()->active()->get()];
            case 'arrondissement':
                return ['quartier', $entity->quartiers()->active()->get()];
            default:
                return [null, collect()];
        }
    }

    /**
     * Options prêtes pour le champ : le zoom accompagne chaque entrée, la carte
     * n'a donc pas à deviner l'échelle du niveau sélectionné.
     */
    protected function formatFilterOptions(?string $childType, $children): array
    {
        if ($childType === null) {
            return [];
        }

        $zoom = [
            'continent' => 3, 'country' => 5, 'province' => 7, 'region' => 9,
            'secteur' => 11, 'city' => 12, 'arrondissement' => 14, 'quartier' => 15,
        ][$childType] ?? 10;

        return $children
            ->filter(fn ($child) => filled($child->name ?? null))
            ->map(fn ($child) => [
                'name'      => $child->name,
                'slug'      => (string) ($child->slug ?? $child->id),
                'type'      => $childType,
                'latitude'  => is_numeric($child->latitude ?? null) ? (float) $child->latitude : null,
                'longitude' => is_numeric($child->longitude ?? null) ? (float) $child->longitude : null,
                'zoom'      => $zoom,
            ])
            ->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)
            ->values()
            ->all();
    }

    /**
     * Chaîne de filtres affichée au-dessus de la carte, calquée sur le fil
     * d'Ariane : un champ par niveau, du plus large au plus fin.
     *
     * Les niveaux au-dessus de la destination courante (et elle-même) sont
     * figés — on est déjà sur cette page. Le premier niveau en dessous est
     * pré-rempli avec les enfants déjà chargés ; les suivants se remplissent
     * en cascade via l'endpoint `children`.
     */
    protected function buildMapFilterChain($type, $entity): array
    {
        $chain = [];

        foreach ($this->ancestorsOf($type, $entity) as $ancestor) {
            $chain[] = [
                'type'    => $ancestor['type'],
                'label'   => $this->typeLabels[$ancestor['type']] ?? $ancestor['type'],
                'fixed'   => true,
                'current' => $ancestor['name'],
                'options' => [],
            ];
        }

        $chain[] = [
            'type'    => $type,
            'label'   => $this->typeLabels[$type] ?? $type,
            'fixed'   => true,
            'current' => $entity->name,
            'options' => [],
        ];

        [$childType, $children] = $this->filterChildren($type, $entity);

        if ($childType !== null && $children->count() > 0) {
            $chain[] = [
                'type'    => $childType,
                'label'   => $this->typeLabels[$childType] ?? $childType,
                'fixed'   => false,
                'current' => null,
                'options' => $this->formatFilterOptions($childType, $children),
            ];
        }

        return $chain;
    }

    /**
     * Ancêtres d'une destination, du plus large au plus proche.
     *
     * Chaque niveau est facultatif (une ville peut pendre d'un secteur, d'une
     * région, d'une province ou directement d'un pays) : on remonte donc de
     * parent en parent au lieu de supposer une chaîne complète.
     */
    protected function ancestorsOf($type, $entity): array
    {
        $parents = [];
        $cursor = $entity;
        $cursorType = $type;

        $parentOf = [
            'country'        => ['continent' => 'continent'],
            'province'       => ['country' => 'country'],
            'region'         => ['province' => 'province'],
            'secteur'        => ['region' => 'region'],
            'city'           => ['secteur' => 'secteur', 'region' => 'region', 'province' => 'province', 'country' => 'country'],
            'arrondissement' => ['ville' => 'city'],
            'quartier'       => ['arrondissement' => 'arrondissement', 'ville' => 'city'],
        ];

        // Garde-fou : la chaîne compte 8 niveaux, une boucle de relations mal
        // formées ne doit pas faire tourner la page indéfiniment.
        for ($depth = 0; $depth < 8; $depth++) {
            $candidates = $parentOf[$cursorType] ?? [];
            $found = null;

            foreach ($candidates as $relation => $parentType) {
                $parent = $cursor->{$relation} ?? null;
                if ($parent) {
                    $found = [$parent, $parentType];
                    break;
                }
            }

            if ($found === null) {
                break;
            }

            [$parent, $parentType] = $found;
            array_unshift($parents, [
                'type' => $parentType,
                'name' => $parent->name,
                'slug' => (string) ($parent->slug ?? $parent->id),
            ]);

            $cursor = $parent;
            $cursorType = $parentType;
        }

        return $parents;
    }

    public function mapPoints($type, $slug, Request $request)
    {
        $normalizedType = $this->typeMap[$type] ?? 'continent';
        $entity = $this->loadEntity($normalizedType, $slug);

        if (!$entity) {
            return response()->json(['success' => false, 'message' => 'Entity not found'], 404);
        }

        // Filtre par destination (cascade de map-filter.blade.php).
        //
        // Continent et pays en font partie : la chaîne du filtre commence au
        // continent sur la carte mondiale des pages d'activité, et au pays sur
        // une page de continent. Les omettre laissait la carte zoomer sur la
        // destination choisie tout en gardant les points du monde entier.
        $filterType = $request->query('filter_type');
        $filterSlug = $request->query('filter_slug');
        $filterEntity = null;
        $normFilter = null;

        if ($filterType && $filterSlug) {
            $filterMap = ['continent' => 'continent', 'country' => 'country', 'province' => 'province', 'region' => 'region', 'city' => 'city', 'ville' => 'city', 'secteur' => 'secteur', 'arrondissement' => 'arrondissement', 'quartier' => 'quartier'];
            $normFilter = $filterMap[$filterType] ?? null;
            if ($normFilter) {
                $filterEntity = $this->loadEntity($normFilter, $filterSlug);
            }
        }

        $target = $filterEntity ?: $entity;
        $targetType = $filterEntity ? $normFilter : $normalizedType;

        $radius = match ($targetType) {
            'continent' => 45,
            'country' => 10,
            'province' => 3.5,
            'region' => 1.5,
            'city' => 0.3,
            'secteur' => 0.15,
            'arrondissement' => 0.1,
            'quartier' => 0.05,
            default => 5,
        };

        $query = MapPoint::with(['details', 'images', 'mainImage'])->active()
            ->visibleOn($targetType)
            ->inDisplayPeriod();

        // La PAGE d'un continent montre tous les points du monde (elle sert de
        // vue d'ensemble) ; un continent CHOISI dans le filtre doit au
        // contraire restreindre la carte à son enveloppe, comme les autres
        // niveaux — sinon filtrer ne filtrerait rien.
        $vueMondiale = $filterEntity === null && $targetType === 'continent';

        // Enveloppe de la DESCENDANCE COMPLÈTE, réservée à une sélection du
        // filtre. Les seuls enfants directs ne suffisent pas dès qu'on remonte
        // la hiérarchie : le Canada n'a que quatre provinces référencées, dont
        // les centres géométriques (Alberta, Ontario, Québec) dessinent une
        // boîte qui n'atteint même pas la ville de Québec. En descendant
        // jusqu'aux quartiers, l'enveloppe épouse le territoire réellement
        // couvert par la base.
        $bornes = $filterEntity ? $this->descendantBounds($targetType, $target) : null;

        if ($bornes) {
            // Marge autour de l'enveloppe : la base ne connaît pas tous les
            // lieux d'un territoire, et un point d'intérêt se trouve souvent
            // un peu au-delà de la dernière destination référencée.
            $padding = match ($targetType) {
                'continent' => 3,
                'country' => 2,
                'province' => 1,
                'region' => 0.5,
                'secteur' => 0.2,
                'arrondissement' => 0.12,
                'quartier' => 0.08,
                default => 0.3,
            };
            $query->whereBetween('latitude', [$bornes['minLat'] - $padding, $bornes['maxLat'] + $padding])
                  ->whereBetween('longitude', [$bornes['minLng'] - $padding, $bornes['maxLng'] + $padding]);
        } elseif (! $vueMondiale) {
            // Try child entities first for accurate bounds (works even if entity lacks lat/lng)
            $childEntities = $this->getChildEntities($targetType, $target);
            $childrenWithLat = $childEntities ? $childEntities->whereNotNull('latitude') : collect();
            if ($childrenWithLat->count() > 0) {
                $padding = match ($targetType) {
                    'continent' => 2,
                    'country' => 1.5,
                    'province' => 1,
                    'region' => 0.5,
                    default => 0.3,
                };
                $query->whereBetween('latitude', [$childrenWithLat->min('latitude') - $padding, $childrenWithLat->max('latitude') + $padding])
                      ->whereBetween('longitude', [$childrenWithLat->min('longitude') - $padding, $childrenWithLat->max('longitude') + $padding]);
            } elseif ($target->latitude && $target->longitude) {
                // Fallback to fixed radius around entity center
                $query->whereBetween('latitude', [$target->latitude - $radius, $target->latitude + $radius])
                      ->whereBetween('longitude', [$target->longitude - $radius, $target->longitude + $radius]);
            }
        }

        $points = $query->orderBy('is_featured', 'desc')->orderBy('views', 'desc')->limit(100)->get();

        $formatted = $points->map(function ($p) {
            $data = [
                'id' => $p->id,
                'title' => $p->title,
                'description' => $p->description,
                'latitude' => (float) $p->latitude,
                'longitude' => (float) $p->longitude,
                'category' => $p->category,
                'type' => $p->type,
                'address' => $p->adresse,
                'city' => $p->ville,
                'youtube_url' => $p->youtube_url,
                'youtube_id' => $p->youtube_id,
                'thumbnail' => $p->thumbnail,
                'is_featured' => (bool) $p->is_featured,
                'has_details_page' => (bool) $p->has_details_page,
                'views' => $p->views,
            ];
            if ($p->details) {
                $data['details'] = [
                    'long_description' => $p->details->long_description,
                    'phone' => $p->details->phone,
                    'email' => $p->details->email,
                    'website' => $p->details->website,
                    'horaires' => $p->details->horaires,
                    'services' => $p->details->services,
                    'tarifs' => $p->details->tarifs,
                    'rating' => (float) $p->details->rating,
                    'reviews_count' => $p->details->reviews_count,
                    'slug' => $p->details->slug,
                ];
            }
            if ($p->images && $p->images->count() > 0) {
                $data['images'] = $p->images->map(fn($img) => ['url' => $img->url, 'thumbnail' => $img->thumb_url, 'caption' => $img->caption, 'is_main' => (bool) $img->is_main]);
            }
            return $data;
        });

        return response()->json([
            'success' => true,
            'data' => $formatted,
            'entity' => ['id' => $entity->id, 'name' => $entity->name, 'type' => $normalizedType, 'latitude' => (float) ($entity->latitude ?? 0), 'longitude' => (float) ($entity->longitude ?? 0)],
        ]);
    }

    protected function loadEntity($type, $slug)
    {
        $slug = trim($slug);
        $service = app(DestinationService::class);

        $entity = match ($type) {
            'continent' => DestinationHelper::continent($slug),
            'country' => DestinationHelper::country($slug),
            'province' => DestinationHelper::province($slug),
            'region' => DestinationHelper::region($slug),
            'city' => DestinationHelper::ville($slug),
            'secteur' => DestinationHelper::secteur($slug),
            'arrondissement' => DestinationHelper::arrondissement($slug),
            'quartier' => DestinationHelper::quartier($slug),
            default => null,
        };

        if ($entity) {
            return $entity;
        }

        // Fallback: resolve by slug if not found by code/iso2/id
        return match ($type) {
            'continent' => $service->getContinentBySlug($slug),
            'country' => $service->getCountryBySlug($slug),
            'province' => $service->getProvinceBySlug($slug),
            'region' => $service->getRegionBySlug($slug),
            'city' => $service->getVilleBySlug($slug),
            'secteur' => $service->getSecteurBySlug($slug),
            'arrondissement' => $service->getArrondissementBySlug($slug),
            'quartier' => $service->getQuartierBySlug($slug),
            default => null,
        };
    }

    protected function buildBreadcrumb($type, $entity)
    {
        $breadcrumb = collect([
            ['label' => 'Accueil', 'url' => url('/')],
            ['label' => 'Destinations', 'url' => url('/destination')],
        ]);

        switch ($type) {
            case 'continent':
                $breadcrumb->push(['label' => $entity->name, 'url' => null]);
                break;

            case 'country':
                if ($entity->continent) {
                    $breadcrumb->push([
                        'label' => $entity->continent->name,
                        'url' => route('travel-destination.show', ['type' => 'continent', 'slug' => $this->entitySlug($entity->continent)]),
                    ]);
                }
                $breadcrumb->push(['label' => $entity->name, 'url' => null]);
                break;

            case 'province':
                $country = $entity->country;
                if ($country) {
                    if ($country->continent) {
                        $breadcrumb->push([
                            'label' => $country->continent->name,
                            'url' => route('travel-destination.show', ['type' => 'continent', 'slug' => $country->continent->slug ?? $country->continent->id]),
                        ]);
                    }
                    $breadcrumb->push([
                        'label' => $country->name,
                        'url' => route('travel-destination.show', ['type' => 'country', 'slug' => $this->entitySlug($country)]),
                    ]);
                }
                $breadcrumb->push(['label' => $entity->name, 'url' => null]);
                break;

            case 'region':
                $hierarchy = $this->getHierarchyChain($entity);
                foreach ($hierarchy as $item) {
                    $breadcrumb->push($item);
                }
                $breadcrumb->push(['label' => $entity->name, 'url' => null]);
                break;

            case 'city':
                $hierarchy = $this->getHierarchyChain($entity);
                foreach ($hierarchy as $item) {
                    $breadcrumb->push($item);
                }
                $breadcrumb->push(['label' => $entity->name, 'url' => null]);
                break;

            case 'secteur':
                $hierarchy = $this->getHierarchyChain($entity);
                foreach ($hierarchy as $item) {
                    $breadcrumb->push($item);
                }
                $breadcrumb->push(['label' => $entity->name, 'url' => null]);
                break;

            case 'arrondissement':
            case 'quartier':
                $hierarchy = $this->getHierarchyChain($entity);
                foreach ($hierarchy as $item) {
                    $breadcrumb->push($item);
                }
                $breadcrumb->push(['label' => $entity->name, 'url' => null]);
                break;
        }

        return $breadcrumb;
    }

    protected function getHierarchyChain($entity)
    {
        $chain = collect();
        $type = class_basename($entity);

        switch ($type) {
            case 'Region':
                $province = $entity->province;
                if ($province) {
                    $country = $province->country;
                    if ($country) {
                        if ($country->continent) {
                            $chain->push([
                                'label' => $country->continent->name,
                                'url' => route('travel-destination.show', ['type' => 'continent', 'slug' => $country->continent->slug ?? $country->continent->id]),
                            ]);
                        }
                        $chain->push([
                            'label' => $country->name,
                            'url' => route('travel-destination.show', ['type' => 'country', 'slug' => $this->entitySlug($country)]),
                        ]);
                    }
                    $chain->push([
                        'label' => $province->name,
                        'url' => route('travel-destination.show', ['type' => 'province', 'slug' => $this->entitySlug($province)]),
                    ]);
                }
                break;

            case 'Ville':
                $region = $entity->region;
                if ($region) {
                    $province = $region->province;
                    if ($province) {
                        $country = $province->country;
                        if ($country) {
                            if ($country->continent) {
                                $chain->push([
                                    'label' => $country->continent->name,
                                    'url' => route('travel-destination.show', ['type' => 'continent', 'slug' => $country->continent->slug ?? $country->continent->id]),
                                ]);
                            }
                            $chain->push([
                                'label' => $country->name,
                                'url' => route('travel-destination.show', ['type' => 'country', 'slug' => $this->entitySlug($country)]),
                            ]);
                        }
                        $chain->push([
                            'label' => $province->name,
                            'url' => route('travel-destination.show', ['type' => 'province', 'slug' => $this->entitySlug($province)]),
                        ]);
                    }
                    $chain->push([
                        'label' => $region->name,
                        'url' => route('travel-destination.show', ['type' => 'region', 'slug' => $this->entitySlug($region)]),
                    ]);
                } else {
                    $province = $entity->province;
                    if ($province) {
                        $country = $province->country;
                        if ($country) {
                            if ($country->continent) {
                                $chain->push([
                                    'label' => $country->continent->name,
                                    'url' => route('travel-destination.show', ['type' => 'continent', 'slug' => $country->continent->slug ?? $country->continent->id]),
                                ]);
                            }
                            $chain->push([
                                'label' => $country->name,
                                'url' => route('travel-destination.show', ['type' => 'country', 'slug' => $this->entitySlug($country)]),
                            ]);
                        }
                        $chain->push([
                            'label' => $province->name,
                            'url' => route('travel-destination.show', ['type' => 'province', 'slug' => $this->entitySlug($province)]),
                        ]);
                    } else {
                        $country = $entity->country;
                        if ($country) {
                            if ($country->continent) {
                                $chain->push([
                                    'label' => $country->continent->name,
                                    'url' => route('travel-destination.show', ['type' => 'continent', 'slug' => $country->continent->slug ?? $country->continent->id]),
                                ]);
                            }
                            $chain->push([
                                'label' => $country->name,
                                'url' => route('travel-destination.show', ['type' => 'country', 'slug' => $this->entitySlug($country)]),
                            ]);
                        }
                    }
                }
                break;

            case 'Secteur':
                $region = $entity->region;
                if ($region) {
                    $province = $region->province;
                    if ($province) {
                        $country = $province->country;
                        if ($country) {
                            if ($country->continent) {
                                $chain->push([
                                    'label' => $country->continent->name,
                                    'url' => route('travel-destination.show', ['type' => 'continent', 'slug' => $country->continent->slug ?? $country->continent->id]),
                                ]);
                            }
                            $chain->push([
                                'label' => $country->name,
                                'url' => route('travel-destination.show', ['type' => 'country', 'slug' => $this->entitySlug($country)]),
                            ]);
                        }
                        $chain->push([
                            'label' => $province->name,
                            'url' => route('travel-destination.show', ['type' => 'province', 'slug' => $this->entitySlug($province)]),
                        ]);
                    }
                    if ($region) {
                        $chain->push([
                            'label' => $region->name,
                            'url' => route('travel-destination.show', ['type' => 'region', 'slug' => $this->entitySlug($region)]),
                        ]);
                    }
                }
                break;

            case 'Arrondissement':
                // Chaîne de la ville parente, puis la ville elle-même
                $ville = $entity->ville;
                if ($ville) {
                    foreach ($this->getHierarchyChain($ville) as $item) {
                        $chain->push($item);
                    }
                    $chain->push([
                        'label' => $ville->name,
                        'url' => route('travel-destination.show', ['type' => 'city', 'slug' => $this->entitySlug($ville)]),
                    ]);
                }
                break;

            case 'Quartier':
                // Chaîne de l'arrondissement parent, puis l'arrondissement lui-même
                $arrondissement = $entity->arrondissement;
                if ($arrondissement) {
                    foreach ($this->getHierarchyChain($arrondissement) as $item) {
                        $chain->push($item);
                    }
                    $chain->push([
                        'label' => $arrondissement->name,
                        'url' => route('travel-destination.show', ['type' => 'arrondissement', 'slug' => $this->entitySlug($arrondissement)]),
                    ]);
                }
                break;
        }

        return $chain;
    }

    protected function buildStats($type, $entity)
    {
        $stats = [];

        if (isset($entity->population) && $entity->population) {
            $stats[] = [
                'label' => 'Population',
                'value' => $entity->population > 1000000
                    ? number_format($entity->population / 1000000, 1) . 'M'
                    : number_format($entity->population),
            ];
        }

        if (isset($entity->area) && $entity->area) {
            $stats[] = [
                'label' => 'Superficie',
                'value' => $entity->area > 10000
                    ? number_format($entity->area / 1000, 0) . 'k km²'
                    : number_format($entity->area) . ' km²',
            ];
        }

        switch ($type) {
            case 'continent':
                if ($entity->countries_count) {
                    $stats[] = ['label' => 'Pays', 'value' => $entity->countries_count];
                }
                $stats[] = ['label' => 'Activités', 'value' => $entity->activities->count()];
                break;
            case 'country':
                $stats[] = ['label' => 'Provinces', 'value' => $entity->provinces->count()];
                $stats[] = ['label' => 'Activités', 'value' => $entity->activities->count()];
                break;
            case 'province':
                $stats[] = ['label' => 'Régions', 'value' => $entity->regions->count()];
                $stats[] = ['label' => 'Villes', 'value' => $entity->villes->count()];
                break;
            case 'region':
                $stats[] = ['label' => 'Villes', 'value' => $entity->villes->count()];
                $stats[] = ['label' => 'Secteurs', 'value' => $entity->secteurs->count()];
                break;
            case 'city':
                $stats[] = ['label' => 'Arrondissements', 'value' => $entity->arrondissements->count()];
                if ($entity->density) {
                    $stats[] = ['label' => 'Densité', 'value' => number_format($entity->density) . '/km²'];
                }
                break;
            case 'secteur':
                $stats[] = ['label' => 'Villes', 'value' => $entity->villes->count()];
                break;
            case 'arrondissement':
                $stats[] = ['label' => 'Quartiers', 'value' => $entity->quartiers->count()];
                if ($entity->density) {
                    $stats[] = ['label' => 'Densité', 'value' => number_format($entity->density) . '/km²'];
                }
                break;
            case 'quartier':
                if ($entity->density) {
                    $stats[] = ['label' => 'Densité', 'value' => number_format($entity->density) . '/km²'];
                }
                if ($entity->households) {
                    $stats[] = ['label' => 'Ménages', 'value' => number_format($entity->households)];
                }
                break;
        }

        return $stats;
    }

    private function entitySlug($entity): string
    {
        return $entity->slug ?? Str::slug($entity->name ?? $entity->id);
    }

    /**
     * Enveloppe géographique d'une destination : le rectangle qui contient
     * TOUTE sa descendance connue (pays, provinces, régions, secteurs, villes,
     * arrondissements, quartiers) et la destination elle-même.
     *
     * Les points d'intérêt ne portent pas de rattachement à une destination :
     * seules leurs coordonnées permettent de les rapporter à un territoire.
     * D'où cette enveloppe, qui suit la descendance niveau par niveau — une
     * requête par niveau, jamais une par entité.
     *
     * Les destinations INACTIVES comptent ici : il s'agit d'une géométrie, pas
     * d'une liste affichée. Les États-Unis et le Mexique ne sont pas publiés,
     * mais l'Amérique du Nord ne s'arrête pas pour autant à la frontière
     * canadienne.
     *
     * @return array{minLat: float, maxLat: float, minLng: float, maxLng: float}|null
     */
    protected function descendantBounds(string $type, $entity): ?array
    {
        $latitudes = [];
        $longitudes = [];

        $retenir = function ($rows) use (&$latitudes, &$longitudes) {
            foreach ($rows as $row) {
                if (is_numeric($row->latitude) && is_numeric($row->longitude)) {
                    $latitudes[] = (float) $row->latitude;
                    $longitudes[] = (float) $row->longitude;
                }
            }
        };

        $retenir([$entity]);

        // Identifiants connus à chaque niveau, alimentés de proche en proche
        // depuis le niveau de départ.
        $ids = [
            'continent' => [], 'country' => [], 'province' => [], 'region' => [],
            'secteur' => [], 'city' => [], 'arrondissement' => [],
        ];

        if (array_key_exists($type, $ids)) {
            $ids[$type] = [$entity->id];
        } elseif ($type !== 'quartier') {
            return null;
        }

        $descendre = function (string $modelClass, array $conditions) use ($retenir) {
            // `$conditions` : colonne => identifiants du parent. Une ville peut
            // pendre d'un secteur, d'une région, d'une province ou directement
            // d'un pays : plusieurs colonnes sont donc interrogées en OU.
            $conditions = array_filter($conditions, fn ($valeurs) => !empty($valeurs));

            if (!$conditions) {
                return collect();
            }

            $rows = $modelClass::query()
                ->where(function ($q) use ($conditions) {
                    foreach ($conditions as $colonne => $valeurs) {
                        $q->orWhereIn($colonne, $valeurs);
                    }
                })
                ->get(['id', 'latitude', 'longitude']);

            $retenir($rows);

            return $rows;
        };

        $ids['country'] = array_merge($ids['country'], $descendre(\App\Models\Country::class, [
            'continent_id' => $ids['continent'],
        ])->pluck('id')->all());

        $ids['province'] = array_merge($ids['province'], $descendre(\App\Models\Province::class, [
            'country_id' => $ids['country'],
        ])->pluck('id')->all());

        $ids['region'] = array_merge($ids['region'], $descendre(\App\Models\Region::class, [
            'province_id' => $ids['province'],
        ])->pluck('id')->all());

        $ids['secteur'] = array_merge($ids['secteur'], $descendre(\App\Models\Secteur::class, [
            'region_id' => $ids['region'],
        ])->pluck('id')->all());

        $ids['city'] = array_merge($ids['city'], $descendre(\App\Models\Ville::class, [
            'secteur_id'  => $ids['secteur'],
            'region_id'   => $ids['region'],
            'province_id' => $ids['province'],
            'country_id'  => $ids['country'],
        ])->pluck('id')->all());

        $ids['arrondissement'] = array_merge($ids['arrondissement'], $descendre(\App\Models\Arrondissement::class, [
            'ville_id' => $ids['city'],
        ])->pluck('id')->all());

        $descendre(\App\Models\Quartier::class, [
            'arrondissement_id' => $ids['arrondissement'],
            'ville_id'          => $ids['city'],
        ]);

        if (!$latitudes) {
            return null;
        }

        return [
            'minLat' => min($latitudes),
            'maxLat' => max($latitudes),
            'minLng' => min($longitudes),
            'maxLng' => max($longitudes),
        ];
    }

    protected function getChildEntities($type, $entity)
    {
        switch ($type) {
            case 'continent':
                return $entity->countries()->active()->get();
            case 'country':
                return $entity->provinces()->active()->get();
            case 'province':
                return $entity->regions()->active()->get();
            case 'region':
                return $entity->villes()->active()->get();
            case 'city':
                return $entity->arrondissements()->active()->get();
            case 'secteur':
                return $entity->villes()->active()->get();
            case 'arrondissement':
                return $entity->quartiers()->active()->get();
            case 'quartier':
                return collect();
            default:
                return collect();
        }
    }
}
