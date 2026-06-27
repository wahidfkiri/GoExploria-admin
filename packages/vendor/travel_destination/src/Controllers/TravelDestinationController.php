<?php

namespace Vendor\TravelDestination\Controllers;

use App\Helpers\DestinationHelper;
use App\Models\MapCategory;
use App\Models\MapPoint;
use App\Models\PageContent;
use App\Services\DestinationService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;

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
    ];

    protected $typeModelMap = [
        'continent' => \App\Models\Continent::class,
        'country' => \App\Models\Country::class,
        'province' => \App\Models\Province::class,
        'region' => \App\Models\Region::class,
        'city' => \App\Models\Ville::class,
        'secteur' => \App\Models\Secteur::class,
    ];

    protected $typeLabels = [
        'continent' => 'Continent',
        'country' => 'Pays',
        'province' => 'Province',
        'region' => 'Région',
        'city' => 'Ville',
        'secteur' => 'Secteur',
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
        if (in_array($normalizedType, ['continent', 'country', 'province', 'region', 'city', 'secteur'])) {
            $radius = match ($normalizedType) {
                'continent' => 45,
                'country' => 10,
                'province' => 3.5,
                'region' => 1.5,
                'city' => 0.3,
                'secteur' => 0.15,
                default => 5,
            };
            $q = MapPoint::with(['details', 'images', 'mainImage'])->active()->whereNotNull('adresse');
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
            $mapPoints = $q->orderBy('is_featured', 'desc')->orderBy('views', 'desc')->limit(500)->get();
        }

        return view('travel-destination::landing.index', compact(
            'entity',
            'normalizedType',
            'slug',
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
            'mapPoints'
        ));
    }

    public function mapPoints($type, $slug, Request $request)
    {
        $normalizedType = $this->typeMap[$type] ?? 'continent';
        $entity = $this->loadEntity($normalizedType, $slug);

        if (!$entity) {
            return response()->json(['success' => false, 'message' => 'Entity not found'], 404);
        }

        // Optional child-entity filter
        $filterType = $request->query('filter_type');
        $filterSlug = $request->query('filter_slug');
        $filterEntity = null;

        if ($filterType && $filterSlug) {
            $filterMap = ['province' => 'province', 'region' => 'region', 'city' => 'city', 'ville' => 'city', 'secteur' => 'secteur'];
            $normFilter = $filterMap[$filterType] ?? null;
            if ($normFilter) {
                $filterEntity = $this->loadEntity($normFilter, $filterSlug);
            }
        }

        $target = $filterEntity ?: $entity;
        $targetType = $filterEntity ? ($filterType ?: $normalizedType) : $normalizedType;

        $radius = match ($targetType) {
            'continent' => 45,
            'country' => 10,
            'province' => 3.5,
            'region' => 1.5,
            'city' => 0.3,
            'secteur' => 0.15,
            default => 5,
        };

        $query = MapPoint::with(['details', 'images', 'mainImage'])->active();

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
                $stats[] = ['label' => 'Altitude', 'value' => ($entity->altitude ?? 0) . 'm'];
                if ($entity->density) {
                    $stats[] = ['label' => 'Densité', 'value' => number_format($entity->density) . '/km²'];
                }
                break;
            case 'secteur':
                $stats[] = ['label' => 'Villes', 'value' => $entity->villes->count()];
                break;
        }

        return $stats;
    }

    private function entitySlug($entity): string
    {
        return $entity->slug ?? Str::slug($entity->name ?? $entity->id);
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
                return collect();
            case 'secteur':
                return $entity->villes()->active()->get();
            default:
                return collect();
        }
    }
}
