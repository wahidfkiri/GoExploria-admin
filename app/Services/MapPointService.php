<?php

namespace App\Services;

use App\Models\MapPoint;
use App\Models\MapPointImage;
use App\Models\MapPointVideo;
use App\Models\MapPointDetail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Collection;

/**
 * Service de gestion des points de carte (Map Points)
 * Fournit un accès optimisé avec mise en cache
 */
class MapPointService
{
    /**
     * Durée du cache en secondes (1 heure pour les points map car ils changent plus souvent)
     */
    const CACHE_DURATION = 3600;

    /**
     * Récupérer tous les points actifs
     */
    public function getMapPoints(array $filters = [], bool $withRelations = false): Collection
    {
        $cacheKey = 'map_points.all.' . md5(json_encode($filters)) . '.' . ($withRelations ? 'with_relations' : 'simple');
        
        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($filters, $withRelations) {
            $query = MapPoint::active();
            
            // Filtres
            if (isset($filters['category'])) {
                $query->byCategory($filters['category']);
            }
            
            if (isset($filters['featured'])) {
                $query->featured();
            }
            
            if (isset($filters['bounds'])) {
                $query->inBounds($filters['bounds']['sw'], $filters['bounds']['ne']);
            }
            
            if (isset($filters['ville'])) {
                $query->where('ville', $filters['ville']);
            }
            
            // Relations
            if ($withRelations) {
                $query->with(['images', 'videos', 'details', 'etablissement']);
            }
            
            return $query->orderBy('is_featured', 'desc')
                        ->orderBy('views', 'desc')
                        ->get();
        });
    }

    /**
     * Récupérer un point par ID
     */
    public function getMapPoint(int $id, bool $withRelations = false)
    {
        $cacheKey = "map_points.point.{$id}." . ($withRelations ? 'with_relations' : 'simple');
        
        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($id, $withRelations) {
            $query = MapPoint::active();
            
            if ($withRelations) {
                $query->with(['images', 'videos', 'details', 'etablissement', 'user']);
            }
            
            return $query->find($id);
        });
    }

    /**
     * Récupérer les points dans une zone géographique (bounds)
     */
    public function getPointsInBounds(array $southWest, array $northEast, ?string $category = null): Collection
    {
        $cacheKey = 'map_points.bounds.' . md5(json_encode([$southWest, $northEast, $category]));
        
        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($southWest, $northEast, $category) {
            $query = MapPoint::active()->inBounds($southWest, $northEast);
            
            if ($category) {
                $query->byCategory($category);
            }
            
            return $query->with(['images' => function ($q) {
                $q->where('is_main', true);
            }])->get();
        });
    }

    /**
     * Récupérer les points par catégorie
     */
    public function getPointsByCategory(string $category, bool $withRelations = false): Collection
    {
        $cacheKey = "map_points.category.{$category}." . ($withRelations ? 'with_relations' : 'simple');
        
        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($category, $withRelations) {
            $query = MapPoint::active()->byCategory($category);
            
            if ($withRelations) {
                $query->with(['images', 'videos', 'details']);
            }
            
            return $query->orderBy('is_featured', 'desc')->get();
        });
    }

    /**
     * Récupérer les points en vedette (featured)
     */
    public function getFeaturedPoints(int $limit = 10, bool $withRelations = false): Collection
    {
        $cacheKey = "map_points.featured.{$limit}." . ($withRelations ? 'with_relations' : 'simple');
        
        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($limit, $withRelations) {
            $query = MapPoint::active()->featured();
            
            if ($withRelations) {
                $query->with(['images', 'videos', 'details']);
            }
            
            return $query->orderBy('views', 'desc')->limit($limit)->get();
        });
    }

    /**
     * Récupérer les images d'un point
     */
    public function getPointImages(int $mapPointId): Collection
    {
        $cacheKey = "map_points.images.{$mapPointId}";
        
        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($mapPointId) {
            return MapPointImage::where('map_point_id', $mapPointId)
                                ->orderBy('is_main', 'desc')
                                ->orderBy('sort_order')
                                ->get();
        });
    }

    /**
     * Récupérer les vidéos d'un point
     */
    public function getPointVideos(int $mapPointId): Collection
    {
        $cacheKey = "map_points.videos.{$mapPointId}";
        
        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($mapPointId) {
            return MapPointVideo::where('map_point_id', $mapPointId)
                                ->orderBy('sort_order')
                                ->get();
        });
    }

    /**
     * Récupérer les détails d'un point
     */
    public function getPointDetails(int $mapPointId)
    {
        $cacheKey = "map_points.details.{$mapPointId}";
        
        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($mapPointId) {
            return MapPointDetail::where('map_point_id', $mapPointId)->first();
        });
    }

    /**
     * Rechercher des points par titre ou description
     */
    public function search(string $query, ?string $category = null): Collection
    {
        try {
            $queryBuilder = MapPoint::active()
                ->where(function ($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%")
                      ->orWhere('description', 'like', "%{$query}%")
                      ->orWhere('ville', 'like', "%{$query}%");
                });
            
            if ($category) {
                $queryBuilder->byCategory($category);
            }
            
            return $queryBuilder->with(['images' => function ($q) {
                $q->where('is_main', true);
            }])->limit(20)->get();
        } catch (\Exception $e) {
            return collect([]);
        }
    }

    /**
     * Récupérer les points par ville
     */
    public function getPointsByVille(string $ville, bool $withRelations = false): Collection
    {
        $cacheKey = "map_points.ville." . md5($ville) . '.' . ($withRelations ? 'with_relations' : 'simple');
        
        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($ville, $withRelations) {
            $query = MapPoint::active()->where('ville', $ville);
            
            if ($withRelations) {
                $query->with(['images', 'videos', 'details']);
            }
            
            return $query->orderBy('is_featured', 'desc')->get();
        });
    }

    /**
     * Récupérer les catégories disponibles
     */
    public function getCategories(): array
    {
        $cacheKey = 'map_points.categories';
        
        return Cache::remember($cacheKey, self::CACHE_DURATION, function () {
            return MapPoint::where('is_active', true)
                ->distinct()
                ->pluck('category')
                ->filter()
                ->values()
                ->toArray();
        });
    }

    /**
     * Récupérer les villes disponibles (liste unique)
     */
    public function getVilles(): array
    {
        $cacheKey = 'map_points.villes';
        
        return Cache::remember($cacheKey, self::CACHE_DURATION, function () {
            return MapPoint::where('is_active', true)
                ->whereNotNull('ville')
                ->where('ville', '!=', '')
                ->distinct()
                ->pluck('ville')
                ->sort()
                ->values()
                ->toArray();
        });
    }

    /**
     * Récupérer les statistiques des points
     */
    public function getStats(): array
    {
        $cacheKey = 'map_points.stats';
        
        return Cache::remember($cacheKey, self::CACHE_DURATION, function () {
            return [
                'total_points' => MapPoint::active()->count(),
                'featured_points' => MapPoint::active()->featured()->count(),
                'points_with_images' => MapPoint::active()->has('images')->count(),
                'points_with_videos' => MapPoint::active()->has('videos')->count(),
                'points_with_details' => MapPoint::active()->has('details')->count(),
                'total_images' => MapPointImage::count(),
                'total_videos' => MapPointVideo::count(),
                'categories' => $this->getCategories(),
                'most_viewed' => MapPoint::active()->orderBy('views', 'desc')->first(),
            ];
        });
    }

    /**
     * Incrémenter les vues d'un point
     */
    public function incrementViews(int $mapPointId): void
    {
        $point = MapPoint::find($mapPointId);
        if ($point) {
            $point->incrementViews();
            // Vider le cache de ce point
            Cache::forget("map_points.point.{$mapPointId}.simple");
            Cache::forget("map_points.point.{$mapPointId}.with_relations");
        }
    }

    /**
     * Vider le cache des points map
     */
    public function clearCache(): void
    {
        Cache::tags(['map_points'])->flush();
    }

    /**
     * Récupérer les points proches d'une coordonnée
     */
    public function getNearbyPoints(float $latitude, float $longitude, float $radiusKm = 5, int $limit = 10): Collection
    {
        // Formule Haversine pour calculer la distance
        // 1 degré de latitude ≈ 111 km
        $latDelta = $radiusKm / 111;
        $lngDelta = $radiusKm / (111 * cos(deg2rad($latitude)));
        
        return MapPoint::active()
            ->whereBetween('latitude', [$latitude - $latDelta, $latitude + $latDelta])
            ->whereBetween('longitude', [$longitude - $lngDelta, $longitude + $lngDelta])
            ->with(['images' => function ($q) {
                $q->where('is_main', true);
            }])
            ->limit($limit)
            ->get();
    }
}
