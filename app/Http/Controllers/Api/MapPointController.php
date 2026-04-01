<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\MapPointService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * API Controller pour les points de carte (Map Points)
 * Fournit des endpoints RESTful en lecture seule
 */
class MapPointController extends Controller
{
    protected MapPointService $mapPointService;

    public function __construct(MapPointService $mapPointService)
    {
        $this->mapPointService = $mapPointService;
    }

    /**
     * GET /api/map-points
     * Récupérer tous les points de carte
     */
    public function index(Request $request): JsonResponse
    {
        $filters = [];
        
        if ($request->has('category')) {
            $filters['category'] = $request->input('category');
        }
        
        if ($request->has('featured')) {
            $filters['featured'] = $request->boolean('featured');
        }
        
        if ($request->has('ville')) {
            $filters['ville'] = $request->input('ville');
        }
        
        // Filtrage par bounds (zone géographique)
        if ($request->has('sw_lat') && $request->has('sw_lng') && $request->has('ne_lat') && $request->has('ne_lng')) {
            $filters['bounds'] = [
                'sw' => [
                    'lat' => $request->input('sw_lat'),
                    'lng' => $request->input('sw_lng')
                ],
                'ne' => [
                    'lat' => $request->input('ne_lat'),
                    'lng' => $request->input('ne_lng')
                ]
            ];
        }
        
        $withRelations = $request->boolean('with_relations', false);
        $points = $this->mapPointService->getMapPoints($filters, $withRelations);

        return response()->json([
            'success' => true,
            'data' => $points,
            'count' => $points->count()
        ]);
    }

    /**
     * GET /api/map-points/{id}
     * Récupérer un point spécifique
     */
    public function show(Request $request, int $id): JsonResponse
    {
        $withRelations = $request->boolean('with_relations', true); // Par défaut true pour un point spécifique
        $point = $this->mapPointService->getMapPoint($id, $withRelations);

        if (!$point) {
            return response()->json([
                'success' => false,
                'message' => 'Point de carte non trouvé'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $point
        ]);
    }

    /**
     * GET /api/map-points/bounds
     * Récupérer les points dans une zone géographique
     */
    public function bounds(Request $request): JsonResponse
    {
        $request->validate([
            'sw_lat' => 'required|numeric',
            'sw_lng' => 'required|numeric',
            'ne_lat' => 'required|numeric',
            'ne_lng' => 'required|numeric',
            'category' => 'nullable|string'
        ]);

        $southWest = [
            'lat' => $request->input('sw_lat'),
            'lng' => $request->input('sw_lng')
        ];
        
        $northEast = [
            'lat' => $request->input('ne_lat'),
            'lng' => $request->input('ne_lng')
        ];
        
        $category = $request->input('category');
        
        $points = $this->mapPointService->getPointsInBounds($southWest, $northEast, $category);

        return response()->json([
            'success' => true,
            'data' => $points,
            'count' => $points->count()
        ]);
    }

    /**
     * GET /api/map-points/category/{category}
     * Récupérer les points par catégorie
     */
    public function byCategory(Request $request, string $category): JsonResponse
    {
        $withRelations = $request->boolean('with_relations', false);
        $points = $this->mapPointService->getPointsByCategory($category, $withRelations);

        return response()->json([
            'success' => true,
            'data' => $points,
            'count' => $points->count(),
            'category' => $category
        ]);
    }

    /**
     * GET /api/map-points/featured
     * Récupérer les points en vedette
     */
    public function featured(Request $request): JsonResponse
    {
        $limit = $request->input('limit', 10);
        $withRelations = $request->boolean('with_relations', false);
        
        $points = $this->mapPointService->getFeaturedPoints($limit, $withRelations);

        return response()->json([
            'success' => true,
            'data' => $points,
            'count' => $points->count()
        ]);
    }

    /**
     * GET /api/map-points/{id}/images
     * Récupérer les images d'un point
     */
    public function images(int $id): JsonResponse
    {
        $images = $this->mapPointService->getPointImages($id);

        return response()->json([
            'success' => true,
            'data' => $images,
            'count' => $images->count(),
            'map_point_id' => $id
        ]);
    }

    /**
     * GET /api/map-points/{id}/videos
     * Récupérer les vidéos d'un point
     */
    public function videos(int $id): JsonResponse
    {
        $videos = $this->mapPointService->getPointVideos($id);

        return response()->json([
            'success' => true,
            'data' => $videos,
            'count' => $videos->count(),
            'map_point_id' => $id
        ]);
    }

    /**
     * GET /api/map-points/{id}/details
     * Récupérer les détails d'un point
     */
    public function details(int $id): JsonResponse
    {
        $details = $this->mapPointService->getPointDetails($id);

        if (!$details) {
            return response()->json([
                'success' => false,
                'message' => 'Détails non trouvés pour ce point'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $details,
            'map_point_id' => $id
        ]);
    }

    /**
     * GET /api/map-points/search
     * Rechercher des points
     */
    public function search(Request $request): JsonResponse
    {
        $request->validate([
            'query' => 'required|string|min:2',
            'category' => 'nullable|string'
        ]);

        $results = $this->mapPointService->search(
            $request->input('query'),
            $request->input('category')
        );

        return response()->json([
            'success' => true,
            'data' => $results,
            'count' => $results->count(),
            'query' => $request->input('query')
        ]);
    }

    /**
     * GET /api/map-points/ville/{ville}
     * Récupérer les points par ville
     */
    public function byVille(Request $request, string $ville): JsonResponse
    {
        $withRelations = $request->boolean('with_relations', false);
        $points = $this->mapPointService->getPointsByVille($ville, $withRelations);

        return response()->json([
            'success' => true,
            'data' => $points,
            'count' => $points->count(),
            'ville' => $ville
        ]);
    }

    /**
     * GET /api/map-points/categories
     * Récupérer toutes les catégories disponibles
     */
    public function categories(): JsonResponse
    {
        $categories = $this->mapPointService->getCategories();

        return response()->json([
            'success' => true,
            'data' => $categories,
            'count' => count($categories)
        ]);
    }

    /**
     * GET /api/map-points/villes
     * Récupérer toutes les villes disponibles (liste unique)
     */
    public function villes(): JsonResponse
    {
        $villes = $this->mapPointService->getVilles();

        return response()->json([
            'success' => true,
            'data' => $villes,
            'count' => count($villes)
        ]);
    }

    /**
     * GET /api/map-points/nearby
     * Récupérer les points proches d'une coordonnée
     */
    public function nearby(Request $request): JsonResponse
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius' => 'nullable|numeric|min:0.1|max:100',
            'limit' => 'nullable|integer|min:1|max:50'
        ]);

        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $radius = $request->input('radius', 5);
        $limit = $request->input('limit', 10);

        $points = $this->mapPointService->getNearbyPoints($latitude, $longitude, $radius, $limit);

        return response()->json([
            'success' => true,
            'data' => $points,
            'count' => $points->count(),
            'center' => [
                'latitude' => $latitude,
                'longitude' => $longitude
            ],
            'radius_km' => $radius
        ]);
    }

    /**
     * POST /api/map-points/{id}/view
     * Incrémenter les vues d'un point
     */
    public function incrementView(int $id): JsonResponse
    {
        $this->mapPointService->incrementViews($id);

        return response()->json([
            'success' => true,
            'message' => 'Vue incrémentée'
        ]);
    }

    /**
     * GET /api/map-points/stats
     * Récupérer les statistiques des points
     */
    public function stats(): JsonResponse
    {
        $stats = $this->mapPointService->getStats();

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }
}
