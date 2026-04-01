<?php

/**
 * Fichier de helpers globaux pour les destinations
 * Ces fonctions sont accessibles partout dans l'application
 */

use App\Helpers\DestinationHelper;

if (!function_exists('destinations_continents')) {
    /**
     * Récupérer tous les continents actifs
     */
    function destinations_continents(bool $withRelations = false)
    {
        return DestinationHelper::continents($withRelations);
    }
}

if (!function_exists('destinations_continent')) {
    /**
     * Récupérer un continent par ID ou code
     */
    function destinations_continent($identifier, bool $withRelations = false)
    {
        return DestinationHelper::continent($identifier, $withRelations);
    }
}

if (!function_exists('destinations_countries')) {
    /**
     * Récupérer tous les pays actifs
     */
    function destinations_countries(?int $continentId = null, bool $withRelations = false)
    {
        return DestinationHelper::countries($continentId, $withRelations);
    }
}

if (!function_exists('destinations_country')) {
    /**
     * Récupérer un pays par ID ou code
     */
    function destinations_country($identifier, bool $withRelations = false)
    {
        return DestinationHelper::country($identifier, $withRelations);
    }
}

if (!function_exists('destinations_provinces')) {
    /**
     * Récupérer toutes les provinces actives
     */
    function destinations_provinces(?int $countryId = null, bool $withRelations = false)
    {
        return DestinationHelper::provinces($countryId, $withRelations);
    }
}

if (!function_exists('destinations_province')) {
    /**
     * Récupérer une province par ID ou code
     */
    function destinations_province($identifier, bool $withRelations = false)
    {
        return DestinationHelper::province($identifier, $withRelations);
    }
}

if (!function_exists('destinations_regions')) {
    /**
     * Récupérer toutes les régions actives
     */
    function destinations_regions(?int $provinceId = null, bool $withRelations = false)
    {
        return DestinationHelper::regions($provinceId, $withRelations);
    }
}

if (!function_exists('destinations_region')) {
    /**
     * Récupérer une région par ID ou code
     */
    function destinations_region($identifier, bool $withRelations = false)
    {
        return DestinationHelper::region($identifier, $withRelations);
    }
}

if (!function_exists('destinations_villes')) {
    /**
     * Récupérer toutes les villes actives
     */
    function destinations_villes(?int $regionId = null, bool $withRelations = false)
    {
        return DestinationHelper::villes($regionId, $withRelations);
    }
}

if (!function_exists('destinations_ville')) {
    /**
     * Récupérer une ville par ID ou code
     */
    function destinations_ville($identifier, bool $withRelations = false)
    {
        return DestinationHelper::ville($identifier, $withRelations);
    }
}

if (!function_exists('destinations_secteurs')) {
    /**
     * Récupérer tous les secteurs actifs
     */
    function destinations_secteurs(?int $regionId = null, bool $withRelations = false)
    {
        return DestinationHelper::secteurs($regionId, $withRelations);
    }
}

if (!function_exists('destinations_secteur')) {
    /**
     * Récupérer un secteur par ID ou code
     */
    function destinations_secteur($identifier, bool $withRelations = false)
    {
        return DestinationHelper::secteur($identifier, $withRelations);
    }
}

if (!function_exists('destinations_search')) {
    /**
     * Rechercher des destinations
     */
    function destinations_search(string $query, ?string $type = null)
    {
        return DestinationHelper::search($query, $type);
    }
}

if (!function_exists('destinations_hierarchy')) {
    /**
     * Récupérer la hiérarchie complète d'une destination
     */
    function destinations_hierarchy(string $type, $identifier)
    {
        return DestinationHelper::hierarchy($type, $identifier);
    }
}

if (!function_exists('destinations_breadcrumb')) {
    /**
     * Générer un breadcrumb pour une destination
     */
    function destinations_breadcrumb($destination, string $type): array
    {
        return DestinationHelper::breadcrumb($destination, $type);
    }
}

if (!function_exists('destinations_format_name')) {
    /**
     * Formater un nom de destination avec sa hiérarchie
     */
    function destinations_format_name($destination, string $type): string
    {
        return DestinationHelper::formatFullName($destination, $type);
    }
}

// ============================================
// CATEGORIES HELPERS
// ============================================

use App\Services\CategoryService;

if (!function_exists('categories_types')) {
    /**
     * Récupérer tous les types de catégories
     */
    function categories_types(bool $withCategories = false)
    {
        return app(CategoryService::class)->getCategorieTypes($withCategories);
    }
}

if (!function_exists('categories_type')) {
    /**
     * Récupérer un type de catégorie par ID ou slug
     */
    function categories_type($identifier, bool $withCategories = false)
    {
        return app(CategoryService::class)->getCategorieType($identifier, $withCategories);
    }
}

if (!function_exists('categories_all')) {
    /**
     * Récupérer toutes les catégories
     */
    function categories_all(?int $typeId = null, bool $withRelations = false)
    {
        return app(CategoryService::class)->getCategories($typeId, $withRelations);
    }
}

if (!function_exists('categories_get')) {
    /**
     * Récupérer une catégorie par ID ou slug
     */
    function categories_get($identifier, bool $withRelations = false)
    {
        return app(CategoryService::class)->getCategory($identifier, $withRelations);
    }
}

if (!function_exists('categories_search')) {
    /**
     * Rechercher des catégories
     */
    function categories_search(string $query, ?int $typeId = null)
    {
        return app(CategoryService::class)->search($query, $typeId);
    }
}

if (!function_exists('categories_by_type')) {
    /**
     * Récupérer les catégories par slug du type
     */
    function categories_by_type(string $typeSlug, bool $withRelations = false)
    {
        return app(CategoryService::class)->getCategoriesByTypeSlug($typeSlug, $withRelations);
    }
}

if (!function_exists('categories_popular')) {
    /**
     * Récupérer les catégories populaires
     */
    function categories_popular(int $limit = 10)
    {
        return app(CategoryService::class)->getPopularCategories($limit);
    }
}

if (!function_exists('categories_grouped')) {
    /**
     * Récupérer les catégories groupées par type
     */
    function categories_grouped()
    {
        return app(CategoryService::class)->getCategoriesGroupedByType();
    }
}

// ============================================
// MENUS HELPERS
// ============================================

use App\Services\MenuService;

if (!function_exists('menus_roots')) {
    /**
     * Récupérer tous les menus racines
     */
    function menus_roots(bool $withChildren = false)
    {
        return app(MenuService::class)->getRootMenus($withChildren);
    }
}

if (!function_exists('menus_tree')) {
    /**
     * Récupérer l'arborescence complète des menus
     */
    function menus_tree(?string $menuType = null)
    {
        return app(MenuService::class)->getMenuTree($menuType);
    }
}

if (!function_exists('menus_get')) {
    /**
     * Récupérer un menu par ID ou slug
     */
    function menus_get($identifier, bool $withChildren = false, bool $withRelations = false)
    {
        return app(MenuService::class)->getMenu($identifier, $withChildren, $withRelations);
    }
}

if (!function_exists('menus_by_type')) {
    /**
     * Récupérer les menus par type
     */
    function menus_by_type(string $type, bool $withChildren = false)
    {
        return app(MenuService::class)->getMenusByType($type, $withChildren);
    }
}

if (!function_exists('menus_children')) {
    /**
     * Récupérer les sous-menus d'un menu parent
     */
    function menus_children(int $parentId, bool $recursive = false)
    {
        return app(MenuService::class)->getChildren($parentId, $recursive);
    }
}

if (!function_exists('menus_breadcrumb')) {
    /**
     * Récupérer le fil d'Ariane d'un menu
     */
    function menus_breadcrumb($menuId): array
    {
        return app(MenuService::class)->getBreadcrumb($menuId);
    }
}

if (!function_exists('menus_build_html')) {
    /**
     * Construire un menu HTML
     */
    function menus_build_html($menus, int $maxDepth = 2, int $currentDepth = 0): string
    {
        return app(MenuService::class)->buildHtmlMenu($menus, $maxDepth, $currentDepth);
    }
}

if (!function_exists('menus_with_pages')) {
    /**
     * Récupérer les menus avec pages associées
     */
    function menus_with_pages()
    {
        return app(MenuService::class)->getMenusWithPages();
    }
}

// ============================================
// MAP POINTS HELPERS
// ============================================

use App\Services\MapPointService;

if (!function_exists('map_points_all')) {
    /**
     * Récupérer tous les points de carte
     */
    function map_points_all(array $filters = [], bool $withRelations = false)
    {
        return app(MapPointService::class)->getMapPoints($filters, $withRelations);
    }
}

if (!function_exists('map_points_get')) {
    /**
     * Récupérer un point de carte par ID
     */
    function map_points_get(int $id, bool $withRelations = false)
    {
        return app(MapPointService::class)->getMapPoint($id, $withRelations);
    }
}

if (!function_exists('map_points_in_bounds')) {
    /**
     * Récupérer les points dans une zone géographique
     */
    function map_points_in_bounds(array $southWest, array $northEast, ?string $category = null)
    {
        return app(MapPointService::class)->getPointsInBounds($southWest, $northEast, $category);
    }
}

if (!function_exists('map_points_by_category')) {
    /**
     * Récupérer les points par catégorie
     */
    function map_points_by_category(string $category, bool $withRelations = false)
    {
        return app(MapPointService::class)->getPointsByCategory($category, $withRelations);
    }
}

if (!function_exists('map_points_featured')) {
    /**
     * Récupérer les points en vedette
     */
    function map_points_featured(int $limit = 10, bool $withRelations = false)
    {
        return app(MapPointService::class)->getFeaturedPoints($limit, $withRelations);
    }
}

if (!function_exists('map_points_images')) {
    /**
     * Récupérer les images d'un point
     */
    function map_points_images(int $mapPointId)
    {
        return app(MapPointService::class)->getPointImages($mapPointId);
    }
}

if (!function_exists('map_points_videos')) {
    /**
     * Récupérer les vidéos d'un point
     */
    function map_points_videos(int $mapPointId)
    {
        return app(MapPointService::class)->getPointVideos($mapPointId);
    }
}

if (!function_exists('map_points_details')) {
    /**
     * Récupérer les détails d'un point
     */
    function map_points_details(int $mapPointId)
    {
        return app(MapPointService::class)->getPointDetails($mapPointId);
    }
}

if (!function_exists('map_points_search')) {
    /**
     * Rechercher des points
     */
    function map_points_search(string $query, ?string $category = null)
    {
        return app(MapPointService::class)->search($query, $category);
    }
}

if (!function_exists('map_points_by_ville')) {
    /**
     * Récupérer les points par ville
     */
    function map_points_by_ville(string $ville, bool $withRelations = false)
    {
        return app(MapPointService::class)->getPointsByVille($ville, $withRelations);
    }
}

if (!function_exists('map_points_categories')) {
    /**
     * Récupérer toutes les catégories disponibles
     */
    function map_points_categories()
    {
        return app(MapPointService::class)->getCategories();
    }
}

if (!function_exists('map_points_nearby')) {
    /**
     * Récupérer les points proches d'une coordonnée
     */
    function map_points_nearby(float $latitude, float $longitude, float $radiusKm = 5, int $limit = 10)
    {
        return app(MapPointService::class)->getNearbyPoints($latitude, $longitude, $radiusKm, $limit);
    }
}
