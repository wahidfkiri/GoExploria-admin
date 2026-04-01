<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * API Controller pour les catégories et types de catégories
 * Fournit des endpoints RESTful en lecture seule
 */
class CategoryController extends Controller
{
    protected CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * GET /api/categories/types
     * Récupérer tous les types de catégories
     */
    public function types(Request $request): JsonResponse
    {
        $withCategories = $request->boolean('with_categories', false);
        $types = $this->categoryService->getCategorieTypes($withCategories);

        return response()->json([
            'success' => true,
            'data' => $types,
            'count' => $types->count()
        ]);
    }

    /**
     * GET /api/categories/types/{identifier}
     * Récupérer un type de catégorie par ID ou slug
     */
    public function type(Request $request, $identifier): JsonResponse
    {
        $withCategories = $request->boolean('with_categories', false);
        $type = $this->categoryService->getCategorieType($identifier, $withCategories);

        if (!$type) {
            return response()->json([
                'success' => false,
                'message' => 'Type de catégorie non trouvé'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $type
        ]);
    }

    /**
     * GET /api/categories
     * Récupérer toutes les catégories (optionnel: filtrer par type)
     */
    public function index(Request $request): JsonResponse
    {
        $typeId = $request->input('type_id');
        $withRelations = $request->boolean('with_relations', false);
        
        $categories = $this->categoryService->getCategories($typeId, $withRelations);

        return response()->json([
            'success' => true,
            'data' => $categories,
            'count' => $categories->count()
        ]);
    }

    /**
     * GET /api/categories/{identifier}
     * Récupérer une catégorie par ID ou slug
     */
    public function show(Request $request, $identifier): JsonResponse
    {
        $withRelations = $request->boolean('with_relations', false);
        $category = $this->categoryService->getCategory($identifier, $withRelations);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Catégorie non trouvée'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $category
        ]);
    }

    /**
     * GET /api/categories/search
     * Rechercher des catégories par nom
     */
    public function search(Request $request): JsonResponse
    {
        $request->validate([
            'query' => 'required|string|min:2',
            'type_id' => 'nullable|integer|exists:categorie_types,id'
        ]);

        $results = $this->categoryService->search(
            $request->input('query'),
            $request->input('type_id')
        );

        return response()->json([
            'success' => true,
            'data' => $results,
            'count' => $results->count(),
            'query' => $request->input('query')
        ]);
    }

    /**
     * GET /api/categories/by-type/{typeSlug}
     * Récupérer les catégories par slug du type
     */
    public function byTypeSlug(Request $request, string $typeSlug): JsonResponse
    {
        $withRelations = $request->boolean('with_relations', false);
        $categories = $this->categoryService->getCategoriesByTypeSlug($typeSlug, $withRelations);

        return response()->json([
            'success' => true,
            'data' => $categories,
            'count' => $categories->count(),
            'type_slug' => $typeSlug
        ]);
    }

    /**
     * GET /api/categories/popular
     * Récupérer les catégories populaires
     */
    public function popular(Request $request): JsonResponse
    {
        $limit = $request->input('limit', 10);
        $categories = $this->categoryService->getPopularCategories($limit);

        return response()->json([
            'success' => true,
            'data' => $categories,
            'count' => $categories->count()
        ]);
    }

    /**
     * GET /api/categories/grouped
     * Récupérer les catégories groupées par type
     */
    public function grouped(): JsonResponse
    {
        $grouped = $this->categoryService->getCategoriesGroupedByType();

        return response()->json([
            'success' => true,
            'data' => $grouped,
            'count' => $grouped->count()
        ]);
    }

    /**
     * GET /api/categories/stats
     * Récupérer les statistiques des catégories
     */
    public function stats(): JsonResponse
    {
        $stats = $this->categoryService->getStats();

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }
}
