<?php

namespace Vendor\GeoMap\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MapPoint;
use App\Models\MapPointDetail;
use App\Models\MapPointImage;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class MapPointController extends Controller
{

    public function preview()
    {
        return view('geo-map::index');
    }
    
    /**
     * Récupère tous les points sur la carte avec filtres
     */
    public function index(Request $request)
    {
        try {
            $query = MapPoint::with(['details', 'images', 'mainImage'])
                ->active()
                // Emplacement de la page appelante (home, continent, … quartier)
                // + période d'affichage paramétrés dans l'espace entreprise.
                ->visibleOn($request->query('context'))
                ->inDisplayPeriod();

            // Filtre par catégorie
            if ($request->has('category') && $request->category !== 'all') {
                $query->byCategory($request->category);
            }

            // Filtre par province - Utilisation des coordonnées géographiques
            if ($request->has('province') && $request->province) {
                $province = Province::where('code', $request->province)
                    ->orWhere('code', strtoupper($request->province))
                    ->first();
                
                if ($province && $province->latitude && $province->longitude) {
                    // Définir une zone autour de la province (environ 200km)
                    $lat = $province->latitude;
                    $lng = $province->longitude;
                    $radius = 2.0; // Degrés (~200km)
                    
                    $query->whereBetween('latitude', [$lat - $radius, $lat + $radius])
                          ->whereBetween('longitude', [$lng - $radius, $lng + $radius]);
                }
            }

            // Filtre par type
            if ($request->has('type') && $request->type) {
                $query->where('type', $request->type);
            }

            // Filtre par zone géographique (bounding box)
            if ($request->has('bounds')) {
                $bounds = json_decode($request->bounds, true);
                if ($bounds && isset($bounds['_southWest']) && isset($bounds['_northEast'])) {
                    $query->whereBetween('latitude', [$bounds['_southWest']['lat'], $bounds['_northEast']['lat']])
                          ->whereBetween('longitude', [$bounds['_southWest']['lng'], $bounds['_northEast']['lng']]);
                }
            }

            // Recherche par terme
            if ($request->has('search') && $request->search) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhere('ville', 'like', "%{$search}%")
                      ->orWhere('adresse', 'like', "%{$search}%")
                      ->orWhereHas('details', function($sq) use ($search) {
                          $sq->where('long_description', 'like', "%{$search}%")
                             ->orWhere('services', 'like', "%{$search}%");
                      });
                });
            }

            // Points mis en avant en premier
            $query->orderBy('is_featured', 'desc')
                  ->orderBy('views', 'desc')
                  ->orderBy('created_at', 'desc');

            // Pagination
            $perPage = $request->get('per_page', 50);
            $mapPoints = $query->paginate($perPage);

            // Formater les données pour la carte
            $formattedPoints = $this->formatForMap($mapPoints->items());

            return response()->json([
                'success' => true,
                'data' => $formattedPoints,
                'meta' => [
                    'current_page' => $mapPoints->currentPage(),
                    'last_page' => $mapPoints->lastPage(),
                    'per_page' => $mapPoints->perPage(),
                    'total' => $mapPoints->total(),
                ],
                'filters' => [
                    'available_categories' => $this->getAvailableCategories(),
                    'available_provinces' => $this->getAvailableProvinces(),
                    'available_types' => $this->getAvailableTypes(),
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération des points map: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du chargement des données',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Récupère un point spécifique par son ID
     */
    public function show($id)
    {
        try {
            $mapPoint = MapPoint::with(['details', 'images', 'mainImage', 'videos'])
                ->active()
                ->findOrFail($id);

            // Incrémenter les vues
            $mapPoint->incrementViews();

            $formattedPoint = $this->formatSinglePoint($mapPoint);

            return response()->json([
                'success' => true,
                'data' => $formattedPoint
            ]);

        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération du point map ' . $id . ': ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Point non trouvé'
            ], 404);
        }
    }

    /**
     * Récupère les points par catégorie
     */
    public function getByCategory($category, Request $request)
    {
        try {
            $query = MapPoint::with(['details', 'images', 'mainImage'])
                ->active()
                ->byCategory($category);

            $perPage = $request->get('per_page', 50);
            $mapPoints = $query->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $this->formatForMap($mapPoints->items()),
                'meta' => [
                    'category' => $category,
                    'current_page' => $mapPoints->currentPage(),
                    'last_page' => $mapPoints->lastPage(),
                    'total' => $mapPoints->total(),
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération par catégorie: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du chargement des données'
            ], 500);
        }
    }

    /**
     * Récupère les points à proximité d'une position
     */
    public function getNearby(Request $request)
    {
        $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'radius' => 'nullable|numeric|min:1|max:50'
        ]);

        try {
            $lat = $request->lat;
            $lng = $request->lng;
            $radius = $request->get('radius', 10); // km par défaut

            // Calcul de la bounding box approximative
            $earthRadius = 6371; // km
            $latDelta = rad2deg($radius / $earthRadius);
            $lngDelta = rad2deg($radius / ($earthRadius * cos(deg2rad($lat))));

            $minLat = $lat - $latDelta;
            $maxLat = $lat + $latDelta;
            $minLng = $lng - $lngDelta;
            $maxLng = $lng + $lngDelta;

            $mapPoints = MapPoint::with(['details', 'images', 'mainImage'])
                ->active()
                ->whereBetween('latitude', [$minLat, $maxLat])
                ->whereBetween('longitude', [$minLng, $maxLng])
                ->orderBy('is_featured', 'desc')
                ->limit(20)
                ->get();

            // Calculer la distance réelle pour chaque point
            foreach ($mapPoints as $point) {
                $point->distance = $this->calculateDistance(
                    $lat, $lng, 
                    $point->latitude, $point->longitude
                );
            }

            $mapPoints = $mapPoints->sortBy('distance');

            return response()->json([
                'success' => true,
                'data' => $this->formatForMap($mapPoints),
                'center' => ['lat' => $lat, 'lng' => $lng],
                'radius' => $radius
            ]);

        } catch (\Exception $e) {
            Log::error('Erreur lors de la recherche à proximité: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la recherche'
            ], 500);
        }
    }

    /**
     * Récupère les points en vedette
     */
    public function getFeatured()
    {
        try {
            $mapPoints = MapPoint::with(['details', 'images', 'mainImage'])
                ->active()
                ->featured()
                ->limit(10)
                ->get();

            return response()->json([
                'success' => true,
                'data' => $this->formatForMap($mapPoints)
            ]);

        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération des points vedettes: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du chargement des données'
            ], 500);
        }
    }

    /**
     * Récupère les statistiques globales
     */
    public function getStats()
    {
        try {
            $stats = [
                'total_points' => MapPoint::active()->count(),
                'categories' => $this->getCategoriesStats(),
                'provinces' => $this->getProvincesStats(),
                'total_views' => MapPoint::active()->sum('views'),
                'featured_count' => MapPoint::active()->featured()->count(),
            ];

            return response()->json([
                'success' => true,
                'data' => $stats
            ]);

        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération des stats: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du chargement des statistiques'
            ], 500);
        }
    }

    /**
     * Récupère tous les points d'une province spécifique
     */
    public function getPointsByProvince($provinceCode)
    {
        try {
            $province = Province::where('code', $provinceCode)
                ->orWhere('code', strtoupper($provinceCode))
                ->first();

            if (!$province) {
                return response()->json([
                    'success' => false,
                    'message' => 'Province non trouvée'
                ], 404);
            }

            // Définir une zone autour de la province
            $radius = 2.5; // Degrés (~250km)
            
            $query = MapPoint::with(['details', 'images', 'mainImage'])
                ->active()
                ->whereBetween('latitude', [$province->latitude - $radius, $province->latitude + $radius])
                ->whereBetween('longitude', [$province->longitude - $radius, $province->longitude + $radius]);

            $mapPoints = $query->orderBy('is_featured', 'desc')->get();

            return response()->json([
                'success' => true,
                'data' => $this->formatForMap($mapPoints),
                'province' => [
                    'id' => $province->id,
                    'name' => $province->name,
                    'code' => $province->code,
                    'latitude' => (float) $province->latitude,
                    'longitude' => (float) $province->longitude,
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération des points par province: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du chargement des données'
            ], 500);
        }
    }

    /**
     * Formatte les données pour la carte
     */
    private function formatForMap($mapPoints)
    {
        return array_map(function($point) {
            return $this->formatSinglePoint($point);
        }, $mapPoints);
    }

    /**
     * Formatte un point individuel
     */
    private function formatSinglePoint($point)
    {
        // Déterminer la province à partir des coordonnées
        $province = $this->getProvinceFromCoordinates($point->latitude, $point->longitude);
        
        $data = [
            'id' => $point->id,
            'name' => $point->title,
            'description' => $point->description,
            'latitude' => (float) $point->latitude,
            'longitude' => (float) $point->longitude,
            'category' => $point->category,
            'type' => $point->type,
            'province' => $province ? $province['code'] : null,
            'province_name' => $province ? $province['name'] : null,
            'address' => $point->adresse,
            'city' => $point->ville,
            'postal_code' => $point->code_postal,
            'is_featured' => (bool) $point->is_featured,
            'thumbnail' => $point->thumbnail,
            'youtube_id' => $point->youtube_id,
            'youtube_url' => $point->youtube_url,
            'has_details_page' => (bool) $point->has_details_page,
            'views' => $point->views,
        ];

        // Ajouter les images
        if ($point->images && $point->images->count() > 0) {
            $data['images'] = $point->images->map(function($image) {
                return [
                    'url' => $image->url,
                    'thumbnail' => $image->thumb_url,
                    'caption' => $image->caption,
                    'is_main' => (bool) $image->is_main
                ];
            });
        }

        // Ajouter l'image principale
        if ($point->mainImage) {
            $data['main_image'] = $point->mainImage->url;
        }

        // Ajouter les détails si disponibles
        if ($point->details) {
            $data['details'] = [
                'long_description' => $point->details->long_description,
                'phone' => $point->details->phone,
                'email' => $point->details->email,
                'website' => $point->details->website,
                'horaires' => $point->details->horaires,
                'services' => $point->details->services,
                'tarifs' => $point->details->tarifs,
                'rating' => (float) $point->details->rating,
                'reviews_count' => $point->details->reviews_count,
                'social_networks' => $point->details->social_networks,
                'contact_person' => $point->details->contact_person,
                'slug' => $point->details->slug,
            ];
        }

        // Ajouter la distance si calculée
        if (isset($point->distance)) {
            $data['distance'] = round($point->distance, 2);
        }

        return $data;
    }

    /**
     * Détermine la province à partir des coordonnées
     */
    private function getProvinceFromCoordinates($lat, $lng)
    {
        $provinces = [
            'ab' => ['name' => 'Alberta', 'bounds' => ['min_lat' => 48.9, 'max_lat' => 60.0, 'min_lng' => -120.0, 'max_lng' => -110.0]],
            'bc' => ['name' => 'Colombie-Britannique', 'bounds' => ['min_lat' => 48.2, 'max_lat' => 60.0, 'min_lng' => -139.0, 'max_lng' => -114.0]],
            'mb' => ['name' => 'Manitoba', 'bounds' => ['min_lat' => 48.9, 'max_lat' => 60.0, 'min_lng' => -102.0, 'max_lng' => -95.0]],
            'nb' => ['name' => 'Nouveau-Brunswick', 'bounds' => ['min_lat' => 44.6, 'max_lat' => 48.0, 'min_lng' => -69.0, 'max_lng' => -63.7]],
            'nl' => ['name' => 'Terre-Neuve-et-Labrador', 'bounds' => ['min_lat' => 46.6, 'max_lat' => 60.4, 'min_lng' => -64.0, 'max_lng' => -52.6]],
            'ns' => ['name' => 'Nouvelle-Écosse', 'bounds' => ['min_lat' => 43.4, 'max_lat' => 47.0, 'min_lng' => -66.0, 'max_lng' => -59.7]],
            'nt' => ['name' => 'Territoires du Nord-Ouest', 'bounds' => ['min_lat' => 60.0, 'max_lat' => 78.0, 'min_lng' => -136.0, 'max_lng' => -102.0]],
            'nu' => ['name' => 'Nunavut', 'bounds' => ['min_lat' => 60.0, 'max_lat' => 83.0, 'min_lng' => -120.0, 'max_lng' => -60.0]],
            'on' => ['name' => 'Ontario', 'bounds' => ['min_lat' => 41.7, 'max_lat' => 56.9, 'min_lng' => -95.2, 'max_lng' => -74.3]],
            'pe' => ['name' => 'Île-du-Prince-Édouard', 'bounds' => ['min_lat' => 45.9, 'max_lat' => 47.1, 'min_lng' => -64.4, 'max_lng' => -62.0]],
            'qc' => ['name' => 'Québec', 'bounds' => ['min_lat' => 45.0, 'max_lat' => 62.6, 'min_lng' => -79.8, 'max_lng' => -57.1]],
            'sk' => ['name' => 'Saskatchewan', 'bounds' => ['min_lat' => 48.9, 'max_lat' => 60.0, 'min_lng' => -110.0, 'max_lng' => -101.4]],
            'yt' => ['name' => 'Yukon', 'bounds' => ['min_lat' => 60.0, 'max_lat' => 69.0, 'min_lng' => -141.0, 'max_lng' => -124.0]],
        ];

        foreach ($provinces as $code => $province) {
            if ($lat >= $province['bounds']['min_lat'] && 
                $lat <= $province['bounds']['max_lat'] && 
                $lng >= $province['bounds']['min_lng'] && 
                $lng <= $province['bounds']['max_lng']) {
                return ['code' => $code, 'name' => $province['name']];
            }
        }

        return null;
    }

    /**
     * Calcule la distance entre deux points (en km)
     */
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371;
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat/2) * sin($dLat/2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon/2) * sin($dLon/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        return $earthRadius * $c;
    }

    /**
     * Récupère toutes les catégories disponibles avec leurs counts
     */
    private function getCategoriesStats()
    {
        return MapPoint::active()
            ->select('category')
            ->selectRaw('count(*) as total')
            ->groupBy('category')
            ->get()
            ->map(function($item) {
                return [
                    'name' => $item->category,
                    'label' => ucfirst($item->category),
                    'count' => $item->total
                ];
            });
    }

    /**
     * Récupère les statistiques des provinces
     */
    private function getProvincesStats()
    {
        try {
            $provinces = Province::active()->get();
            $stats = [];

            foreach ($provinces as $province) {
                // Compter les points map dans cette province
                $radius = 2.5; // Degrés
                $pointsCount = MapPoint::active()
                    ->whereBetween('latitude', [$province->latitude - $radius, $province->latitude + $radius])
                    ->whereBetween('longitude', [$province->longitude - $radius, $province->longitude + $radius])
                    ->count();

                $stats[] = [
                    'id' => $province->id,
                    'code' => $province->code,
                    'name' => $province->name,
                    'capital' => $province->capital,
                    'latitude' => (float) $province->latitude,
                    'longitude' => (float) $province->longitude,
                    'map_points_count' => $pointsCount,
                    'flag_url' => $province->flag ? asset('storage/' . $province->flag) : null,
                ];
            }

            // Trier par nombre de points
            usort($stats, function($a, $b) {
                return $b['map_points_count'] - $a['map_points_count'];
            });

            return $stats;

        } catch (\Exception $e) {
            Log::error('Erreur getProvincesStats: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Récupère les catégories disponibles pour les filtres
     */
    private function getAvailableCategories()
    {
        return MapPoint::active()
            ->distinct()
            ->pluck('category')
            ->map(function($category) {
                return [
                    'value' => $category,
                    'label' => ucfirst($category)
                ];
            });
    }

    /**
     * Récupère les provinces disponibles pour les filtres
     */
    private function getAvailableProvinces()
    {
        try {
            $provinces = Province::active()->get();
            
            return $provinces->map(function($province) {
                return [
                    'code' => $province->code,
                    'name' => $province->name,
                    'latitude' => (float) $province->latitude,
                    'longitude' => (float) $province->longitude,
                ];
            });
            
        } catch (\Exception $e) {
            Log::error('Erreur getAvailableProvinces: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Récupère les types disponibles pour les filtres
     */
    private function getAvailableTypes()
    {
        return MapPoint::active()
            ->whereNotNull('type')
            ->distinct()
            ->pluck('type')
            ->map(function($type) {
                return [
                    'value' => $type,
                    'label' => ucfirst($type)
                ];
            });
    }
}