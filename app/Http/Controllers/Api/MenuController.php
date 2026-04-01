<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\MenuService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * API Controller pour les menus hiérarchiques
 * Fournit des endpoints RESTful en lecture seule
 */
class MenuController extends Controller
{
    protected MenuService $menuService;

    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    /**
     * GET /api/menus/roots
     * Récupérer tous les menus racines
     */
    public function roots(Request $request): JsonResponse
    {
        $withChildren = $request->boolean('with_children', false);
        $menus = $this->menuService->getRootMenus($withChildren);

        return response()->json([
            'success' => true,
            'data' => $menus,
            'count' => $menus->count()
        ]);
    }

    /**
     * GET /api/menus/tree
     * Récupérer l'arborescence complète des menus
     */
    public function tree(Request $request): JsonResponse
    {
        $menuType = $request->input('menu_type');
        $tree = $this->menuService->getMenuTree($menuType);

        return response()->json([
            'success' => true,
            'data' => $tree,
            'count' => $tree->count()
        ]);
    }

    /**
     * GET /api/menus/{identifier}
     * Récupérer un menu par ID ou slug
     */
    public function show(Request $request, $identifier): JsonResponse
    {
        $withChildren = $request->boolean('with_children', false);
        $withRelations = $request->boolean('with_relations', false);
        
        $menu = $this->menuService->getMenu($identifier, $withChildren, $withRelations);

        if (!$menu) {
            return response()->json([
                'success' => false,
                'message' => 'Menu non trouvé'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $menu
        ]);
    }

    /**
     * GET /api/menus/by-type/{type}
     * Récupérer les menus par type
     */
    public function byType(Request $request, string $type): JsonResponse
    {
        $withChildren = $request->boolean('with_children', false);
        $menus = $this->menuService->getMenusByType($type, $withChildren);

        return response()->json([
            'success' => true,
            'data' => $menus,
            'count' => $menus->count(),
            'type' => $type
        ]);
    }

    /**
     * GET /api/menus/{parentId}/children
     * Récupérer les sous-menus d'un menu parent
     */
    public function children(Request $request, int $parentId): JsonResponse
    {
        $recursive = $request->boolean('recursive', false);
        $children = $this->menuService->getChildren($parentId, $recursive);

        return response()->json([
            'success' => true,
            'data' => $children,
            'count' => $children->count(),
            'parent_id' => $parentId
        ]);
    }

    /**
     * GET /api/menus/by-category/{categoryId}
     * Récupérer les menus liés à une catégorie
     */
    public function byCategory(int $categoryId): JsonResponse
    {
        $menus = $this->menuService->getMenusByCategory($categoryId);

        return response()->json([
            'success' => true,
            'data' => $menus,
            'count' => $menus->count(),
            'category_id' => $categoryId
        ]);
    }

    /**
     * GET /api/menus/by-activity/{activityId}
     * Récupérer les menus liés à une activité
     */
    public function byActivity(int $activityId): JsonResponse
    {
        $menus = $this->menuService->getMenusByActivity($activityId);

        return response()->json([
            'success' => true,
            'data' => $menus,
            'count' => $menus->count(),
            'activity_id' => $activityId
        ]);
    }

    /**
     * GET /api/menus/search
     * Rechercher des menus par titre
     */
    public function search(Request $request): JsonResponse
    {
        $request->validate([
            'query' => 'required|string|min:2'
        ]);

        $results = $this->menuService->search($request->input('query'));

        return response()->json([
            'success' => true,
            'data' => $results,
            'count' => $results->count(),
            'query' => $request->input('query')
        ]);
    }

    /**
     * GET /api/menus/{identifier}/breadcrumb
     * Récupérer le fil d'Ariane d'un menu
     */
    public function breadcrumb($identifier): JsonResponse
    {
        $breadcrumb = $this->menuService->getBreadcrumb($identifier);

        if (empty($breadcrumb)) {
            return response()->json([
                'success' => false,
                'message' => 'Menu non trouvé'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $breadcrumb
        ]);
    }

    /**
     * GET /api/menus/with-pages
     * Récupérer les menus avec pages associées
     */
    public function withPages(): JsonResponse
    {
        $menus = $this->menuService->getMenusWithPages();

        return response()->json([
            'success' => true,
            'data' => $menus,
            'count' => $menus->count()
        ]);
    }

    /**
     * GET /api/menus/html
     * Construire un menu HTML
     */
    public function html(Request $request): JsonResponse
    {
        $request->validate([
            'max_depth' => 'nullable|integer|min:1|max:5'
        ]);

        $maxDepth = $request->input('max_depth', 2);
        $menus = $this->menuService->getRootMenus(true);
        $html = $this->menuService->buildHtmlMenu($menus, $maxDepth);

        return response()->json([
            'success' => true,
            'html' => $html,
            'max_depth' => $maxDepth
        ]);
    }

    /**
     * GET /api/menus/stats
     * Récupérer les statistiques des menus
     */
    public function stats(): JsonResponse
    {
        $stats = $this->menuService->getStats();

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }
}
