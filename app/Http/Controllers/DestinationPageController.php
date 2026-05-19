<?php

namespace App\Http\Controllers;

use App\Models\Continent;
use App\Models\Country;
use App\Models\CountryMedia;
use App\Models\MapPoint;
use App\Models\Plan;
use App\Models\Province;
use App\Models\Region;
use App\Models\Secteur;
use App\Models\Slider;
use App\Models\Ville;
use App\Services\DestinationService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class DestinationPageController extends Controller
{
    protected $destinationService;

    public function __construct(DestinationService $destinationService)
    {
        $this->destinationService = $destinationService;
    }

    /**
     * Afficher la page d'un continents
     */
    public function continent(string $slug)
    {
        $continent = $this->destinationService->getContinentBySlug($slug);
        
        if (!$continent) {
            abort(404, 'Continent non trouvé');
        }

        // Charger les pays du continent
        $countries = $this->destinationService->getCountriesByContinent($continent->id);

        return $this->renderHomeForDestination($this->resolvedFromModel('continent', $continent));
    }

    /**
     * Afficher la page d'un pays
     */
    public function country(string $slug)
    {
        $country = $this->destinationService->getCountryBySlug($slug);
        
        if (!$country) {
            abort(404, 'Pays non trouvé');
        }

        // Charger les provinces du pays
        $provinces = $this->destinationService->getProvincesByCountry($country->id);

        return $this->renderHomeForDestination($this->resolvedFromModel('country', $country));
    }

    /**
     * Afficher la page d'une province
     */
    public function province(string $slug)
    {
        $province = $this->destinationService->getProvinceBySlug($slug);
        
        if (!$province) {
            abort(404, 'Province non trouvée');
        }

        // Charger les régions de la province
        $regions = $this->destinationService->getRegionsByProvince($province->id);

        return $this->renderHomeForDestination($this->resolvedFromModel('province', $province));
    }

    /**
     * Afficher la page d'une région
     */
    public function region(string $slug)
    {
        $region = $this->destinationService->getRegionBySlug($slug);
        
        if (!$region) {
            abort(404, 'Région non trouvée');
        }

        // Charger les villes de la région
        $villes = $this->destinationService->getVillesByRegion($region->id);

        return $this->renderHomeForDestination($this->resolvedFromModel('region', $region));
    }

    /**
     * Afficher la page d'une ville
     */
    public function ville(string $slug)
    {
        $ville = $this->destinationService->getVilleBySlug($slug);
        
        if (!$ville) {
            abort(404, 'Ville non trouvée');
        }

        return $this->renderHomeForDestination($this->resolvedFromModel('ville', $ville));
    }

    /**
     * Afficher la page d'un secteur
     */
    public function secteur(string $slug)
    {
        $secteur = $this->destinationService->getSecteurBySlug($slug);
        
        if (!$secteur) {
            abort(404, 'Secteur non trouvé');
        }

        return $this->renderHomeForDestination($this->resolvedFromModel('secteur', $secteur));
    }

    /**
     * Page d'index des destinations
     */
    public function index()
    {
        $continents = $this->destinationService->getAllContinents();
        
        return view('destinations.index', compact('continents'));
    }

    /**
     * Afficher une destination depuis un fil d'Ariane:
     * continent/pays/province/region/ville/secteur.
     */
    public function hierarchy(string $path)
    {
        $segments = collect(explode('/', trim($path, '/')))
            ->map(fn ($segment) => Str::slug(urldecode($segment)))
            ->filter()
            ->values()
            ->all();

        if ($segments === []) {
            abort(404);
        }

        $resolved = $this->resolveHierarchyPath($segments);

        if (!$resolved) {
            abort(404);
        }

        return $this->renderHomeForDestination($resolved);
    }

    /**
     * Même logique que hierarchy(), mais gardée séparée pour la route racine.
     */
    public function hierarchyFromRoot(string $destinationPath)
    {
        return $this->hierarchy($destinationPath);
    }

    private function resolvedFromModel(string $type, Model $model): array
    {
        $items = [];

        $country = null;
        $province = null;
        $region = null;

        if ($type === 'continent') {
            $items['continent'] = $model;
        }

        if ($type === 'country') {
            $country = $model;
        }

        if ($type === 'province') {
            $province = $model;
            $country = $this->activeFind(Country::class, $province->country_id ?? null);
        }

        if ($type === 'region') {
            $region = $model;
            $province = $this->activeFind(Province::class, $region->province_id ?? null);
            $country = $province ? $this->activeFind(Country::class, $province->country_id ?? null) : null;
        }

        if ($type === 'ville') {
            $region = $this->activeFind(Region::class, $model->region_id ?? null);
            $province = $this->activeFind(Province::class, $model->province_id ?? ($region->province_id ?? null));
            $country = $this->activeFind(Country::class, $model->country_id ?? ($province->country_id ?? null));
        }

        if ($type === 'secteur') {
            $region = $this->activeFind(Region::class, $model->region_id ?? null);
            $province = $region ? $this->activeFind(Province::class, $region->province_id ?? null) : null;
            $country = $province ? $this->activeFind(Country::class, $province->country_id ?? null) : null;
        }

        if ($country) {
            $continent = $this->activeFind(Continent::class, $country->continent_id ?? null);
            if ($continent) {
                $items['continent'] = $continent;
            }
            $items['country'] = $country;
        }

        if ($province) {
            $items['province'] = $province;
        }

        if ($region) {
            $items['region'] = $region;
        }

        if ($type === 'ville') {
            $items['ville'] = $model;
        }

        if ($type === 'secteur') {
            $items['secteur'] = $model;
        }

        return [
            'items' => $items,
            'current_type' => $type,
            'current' => $model,
        ];
    }

    private function activeFind(string $modelClass, $id): ?Model
    {
        if (!$id) {
            return null;
        }

        return $modelClass::active()->find($id);
    }

    private function renderHomeForDestination(array $resolved)
    {
        $sliders = Slider::active()->ordered()->get();

        $plans = Plan::active()
            ->ordered()
            ->with([
                'activeDestinations',
                'plugins' => function ($query) {
                    $query->orderBy('name');
                },
            ])
            ->get();

        $current = $resolved['current'];
        $destinationContext = $this->buildDestinationContext($resolved);
        $geoMapDestinationContext = $this->buildGeoMapContext($resolved);

        return view('home-v2.index', compact(
            'sliders',
            'plans',
            'destinationContext',
            'geoMapDestinationContext',
            'current'
        ));
    }

    private function resolveHierarchyPath(array $segments): ?array
    {
        $types = [
            'continent' => Continent::class,
            'country' => Country::class,
            'province' => Province::class,
            'region' => Region::class,
            'ville' => Ville::class,
            'secteur' => Secteur::class,
        ];

        if (class_exists('App\\Models\\Quartier')) {
            $types['quartier'] = 'App\\Models\\Quartier';
        }

        $resolved = [];

        foreach ($segments as $index => $segment) {
            $type = array_keys($types)[$index] ?? null;

            if (!$type) {
                return null;
            }

            $model = $this->findActiveModelBySlug($types[$type], $segment, $resolved);

            if (!$model) {
                return null;
            }

            $resolved[$type] = $model;
        }

        $currentType = array_key_last($resolved);

        return [
            'items' => $resolved,
            'current_type' => $currentType,
            'current' => $resolved[$currentType],
        ];
    }

    private function findActiveModelBySlug(string $modelClass, string $slug, array $parents): ?Model
    {
        /** @var Model $model */
        $model = new $modelClass();
        $table = $model->getTable();
        $query = $modelClass::query();

        if (Schema::hasColumn($table, 'is_active')) {
            $query->where('is_active', true);
        }

        $this->applyParentConstraint($query, $table, $parents);

        return $query->get()->first(function ($item) use ($slug) {
            foreach (['slug', 'name', 'code', 'iso2'] as $field) {
                $value = trim((string) ($item->{$field} ?? ''));
                if ($value !== '' && Str::slug($value) === $slug) {
                    return true;
                }
            }

            return false;
        });
    }

    private function applyParentConstraint($query, string $table, array $parents): void
    {
        if (isset($parents['continent']) && Schema::hasColumn($table, 'continent_id')) {
            $query->where('continent_id', $parents['continent']->id);
        }

        if (isset($parents['country']) && Schema::hasColumn($table, 'country_id')) {
            $query->where('country_id', $parents['country']->id);
        }

        if (isset($parents['province']) && Schema::hasColumn($table, 'province_id')) {
            $query->where('province_id', $parents['province']->id);
        }

        if (isset($parents['region']) && Schema::hasColumn($table, 'region_id')) {
            $query->where('region_id', $parents['region']->id);
        }

        if (isset($parents['ville']) && Schema::hasColumn($table, 'ville_id')) {
            $query->where('ville_id', $parents['ville']->id);
        }

        if (isset($parents['secteur']) && Schema::hasColumn($table, 'secteur_id')) {
            $query->where('secteur_id', $parents['secteur']->id);
        }
    }

    private function buildDestinationContext(array $resolved): array
    {
        $current = $resolved['current'];
        $name = $this->modelName($current);
        $items = $resolved['items'];

        return [
            'name' => $name,
            'title_suffix' => " pour {$name}",
            'type' => $resolved['current_type'],
            'path' => collect($items)->map(fn ($item) => Str::slug($this->modelName($item)))->implode('/'),
            'breadcrumb' => collect($items)->map(function ($item, $type) {
                return [
                    'type' => $type,
                    'name' => $this->modelName($item),
                    'slug' => Str::slug($this->modelName($item)),
                    'latitude' => $this->coordinate($item, 'latitude'),
                    'longitude' => $this->coordinate($item, 'longitude'),
                ];
            })->values()->all(),
        ];
    }

    private function buildGeoMapContext(array $resolved): array
    {
        $current = $resolved['current'];
        $currentType = $resolved['current_type'];
        $children = $this->childrenFor($currentType, $current);
        $center = $this->centerFor($resolved, $children);
        $country = $resolved['items']['country'] ?? null;
        $videos = $this->videosFor($country, $current);
        $places = $this->placesFor($resolved, $children, $videos, $center);

        return [
            'destination' => [
                'name' => $this->modelName($current),
                'type' => $currentType,
                'latitude' => $center['lat'],
                'longitude' => $center['lng'],
                'zoom' => $this->zoomFor($currentType),
            ],
            'filters' => [
                'label' => $this->filterLabelFor($currentType),
                'all_label' => $this->filterAllLabelFor($currentType),
                'child_type' => $this->childTypeFor($currentType),
                'items' => $children->map(fn ($item) => [
                    'code' => Str::slug($this->modelName($item)),
                    'name' => $this->modelName($item),
                    'type' => $this->childTypeFor($currentType),
                    'lat' => $this->coordinate($item, 'latitude'),
                    'lng' => $this->coordinate($item, 'longitude'),
                ])->values()->all(),
            ],
            'breadcrumb' => $this->buildDestinationContext($resolved)['breadcrumb'],
            'places' => $places,
        ];
    }

    private function childrenFor(string $type, Model $model): Collection
    {
        return match ($type) {
            'continent' => Country::active()->where('continent_id', $model->id)->orderBy('name')->get(),
            'country' => Province::active()->where('country_id', $model->id)->orderBy('name')->get(),
            'province' => Region::active()->where('province_id', $model->id)->orderBy('name')->get(),
            'region' => Ville::active()->where('region_id', $model->id)->orderBy('name')->get(),
            'ville' => $this->secteursForVille($model),
            'secteur' => Ville::active()->where('secteur_id', $model->id)->orderBy('name')->get(),
            default => collect(),
        };
    }

    private function secteursForVille(Model $ville): Collection
    {
        $query = Secteur::active()->orderBy('name');
        $table = (new Secteur())->getTable();

        if (Schema::hasColumn($table, 'ville_id')) {
            return $query->where('ville_id', $ville->id)->get();
        }

        if ($ville->region_id) {
            return $query->where('region_id', $ville->region_id)->get();
        }

        return collect();
    }

    private function centerFor(array $resolved, Collection $children): array
    {
        foreach (array_reverse($resolved['items']) as $item) {
            $lat = $this->coordinate($item, 'latitude');
            $lng = $this->coordinate($item, 'longitude');
            if ($lat !== null && $lng !== null) {
                return ['lat' => $lat, 'lng' => $lng];
            }
        }

        $childWithCoordinates = $children->first(fn ($item) => $this->coordinate($item, 'latitude') !== null && $this->coordinate($item, 'longitude') !== null);

        if ($childWithCoordinates) {
            return [
                'lat' => $this->coordinate($childWithCoordinates, 'latitude'),
                'lng' => $this->coordinate($childWithCoordinates, 'longitude'),
            ];
        }

        return ['lat' => 52.0, 'lng' => -85.0];
    }

    private function placesFor(array $resolved, Collection $children, Collection $videos, array $center): array
    {
        $current = $resolved['current'];
        $places = collect([
            $this->placePayload($current, $resolved['current_type'], $center, $videos->first())
        ]);

        $childPlaces = $children
            ->filter(fn ($item) => $this->coordinate($item, 'latitude') !== null && $this->coordinate($item, 'longitude') !== null)
            ->values()
            ->map(function ($item, $index) use ($videos) {
                return $this->placePayload($item, 'tourism', [
                    'lat' => $this->coordinate($item, 'latitude'),
                    'lng' => $this->coordinate($item, 'longitude'),
                ], $videos->get(($index + 1) % max($videos->count(), 1)));
            });

        $mapPoints = $this->mapPointsNear($center)->map(function (MapPoint $point) {
            return [
                'id' => 'map-point-' . $point->id,
                'name' => $point->title,
                'latitude' => (float) $point->latitude,
                'longitude' => (float) $point->longitude,
                'category' => $point->category ?: 'tourism',
                'province' => $point->ville ?: 'Destination',
                'description' => $point->description,
                'youtube_id' => $point->youtube_id,
                'image' => $point->thumbnail,
                'details_url' => $point->details_url,
                'has_details_page' => (bool) $point->has_details_page,
            ];
        });

        return $places->merge($childPlaces)->merge($mapPoints)->values()->all();
    }

    private function placePayload(Model $item, string $category, array $center, $video = null): array
    {
        $name = $this->modelName($item);
        $description = (string) ($item->description ?? "Découvrez les espaces, activités et opportunités à {$name}.");
        $videoId = $video ? ($video['youtube_id'] ?? null) : null;

        return [
            'id' => 'destination-' . $item->getTable() . '-' . $item->id,
            'name' => $name,
            'latitude' => $center['lat'],
            'longitude' => $center['lng'],
            'category' => in_array($category, ['country', 'province', 'region', 'ville', 'secteur', 'continent'], true) ? 'tourism' : $category,
            'province' => $name,
            'description' => $description,
            'youtube_id' => $videoId,
            'image' => $this->imageFor($item, $video),
            'details_url' => url('/' . Str::slug($name)),
            'has_details_page' => false,
        ];
    }

    private function mapPointsNear(array $center): Collection
    {
        if (!Schema::hasTable('map_points')) {
            return collect();
        }

        return MapPoint::active()
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->whereBetween('latitude', [$center['lat'] - 3, $center['lat'] + 3])
            ->whereBetween('longitude', [$center['lng'] - 3, $center['lng'] + 3])
            ->limit(20)
            ->get();
    }

    private function videosFor(?Model $country, Model $current): Collection
    {
        $videos = collect();

        if ($country && Schema::hasTable('country_medias')) {
            $videos = CountryMedia::active()
                ->videos()
                ->where('country_id', $country->id)
                ->orderBy('sort_order')
                ->limit(8)
                ->get()
                ->map(fn (CountryMedia $media) => [
                    'title' => $media->title,
                    'youtube_id' => $media->video_id ?: $this->extractYoutubeId($media->video_url),
                    'image' => $media->image_url,
                ])
                ->filter(fn ($video) => !empty($video['youtube_id']))
                ->values();
        }

        if ($videos->isNotEmpty()) {
            return $videos;
        }

        return collect([
            ['title' => 'Destination GoExploria', 'youtube_id' => 'X2-G_tOi0Z0', 'image' => null],
            ['title' => 'Expérience locale', 'youtube_id' => 'ZUYWYGZOjk8', 'image' => null],
            ['title' => 'Découverte destination', 'youtube_id' => '0edALYi7_Qs', 'image' => null],
        ]);
    }

    private function extractYoutubeId(?string $url): ?string
    {
        if (!$url) {
            return null;
        }

        if (preg_match('~(?:youtu\.be/|youtube\.com/(?:watch\?v=|embed/|shorts/))([A-Za-z0-9_-]{6,})~', $url, $matches)) {
            return $matches[1];
        }

        return null;
    }

    private function imageFor(Model $item, $video = null): string
    {
        foreach (['image', 'flag'] as $field) {
            $value = trim((string) ($item->{$field} ?? ''));
            if ($value !== '') {
                return Str::startsWith($value, ['http://', 'https://']) ? $value : asset('storage/' . ltrim($value, '/'));
            }
        }

        if ($video && !empty($video['image'])) {
            return $video['image'];
        }

        if ($video && !empty($video['youtube_id'])) {
            return "https://img.youtube.com/vi/{$video['youtube_id']}/hqdefault.jpg";
        }

        return asset('images/default-placeholder.jpg');
    }

    private function modelName(Model $model): string
    {
        return (string) ($model->name ?? $model->title ?? $model->code ?? 'Destination');
    }

    private function coordinate(Model $model, string $field): ?float
    {
        $value = $model->{$field} ?? null;

        return is_numeric($value) ? (float) $value : null;
    }

    private function zoomFor(string $type): int
    {
        return match ($type) {
            'continent' => 3,
            'country' => 5,
            'province' => 6,
            'region' => 8,
            'ville' => 11,
            'secteur' => 13,
            default => 6,
        };
    }

    private function filterLabelFor(string $type): string
    {
        return match ($type) {
            'continent' => 'Pays (Zoom) :',
            'country' => 'Provinces (Zoom) :',
            'province' => 'Régions (Zoom) :',
            'region' => 'Ville (Zoom) :',
            'ville' => 'Secteur/Quartier (Zoom) :',
            'secteur' => 'Ville/Quartier (Zoom) :',
            default => 'Destination liée (Zoom) :',
        };
    }

    private function filterAllLabelFor(string $type): string
    {
        return match ($type) {
            'continent' => 'Tous les pays',
            'country' => 'Toutes les provinces',
            'province' => 'Toutes les régions',
            'region' => 'Toutes les villes',
            'ville' => 'Tous les secteurs/quartiers',
            'secteur' => 'Toutes les villes/quartiers',
            default => 'Toutes les destinations',
        };
    }

    private function childTypeFor(string $type): string
    {
        return match ($type) {
            'continent' => 'country',
            'country' => 'province',
            'province' => 'region',
            'region' => 'ville',
            'ville' => 'secteur',
            'secteur' => 'ville',
            default => 'destination',
        };
    }
}


