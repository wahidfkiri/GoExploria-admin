<?php

namespace App\Services;

use App\Models\Menu;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Collection;

/**
 * Service de gestion des menus hiérarchiques
 * Fournit un accès optimisé avec mise en cache
 */
class MenuService
{
    /**
     * Durée du cache en secondes (24 heures)
     */
    const CACHE_DURATION = 86400;

    /**
     * Récupérer tous les menus racines (sans parent) actifs
     */
    public function getRootMenus(bool $withChildren = false): Collection
    {
        $cacheKey = 'menus.roots.' . ($withChildren ? 'with_children' : 'simple');
        
        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($withChildren) {
            $query = Menu::active()->roots()->orderBy('order');
            
            if ($withChildren) {
                $query->with(['activeChildren' => function ($q) {
                    $q->orderBy('order');
                }]);
            }
            
            return $query->get();
        });
    }

    /**
     * Récupérer un menu par ID ou slug
     */
    public function getMenu($identifier, bool $withChildren = false, bool $withRelations = false)
    {
        $cacheKey = "menus.menu.{$identifier}." . ($withChildren ? 'with_children' : 'simple') . '.' . ($withRelations ? 'with_relations' : 'no_relations');
        
        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($identifier, $withChildren, $withRelations) {
            $query = Menu::active();
            
            if ($withChildren) {
                $query->with(['activeChildren' => function ($q) {
                    $q->orderBy('order');
                }]);
            }
            
            if ($withRelations) {
                $query->with(['category', 'activity', 'parent']);
            }
            
            return is_numeric($identifier) 
                ? $query->find($identifier)
                : $query->where('slug', $identifier)->first();
        });
    }

    /**
     * Récupérer l'arborescence complète des menus
     */
    public function getMenuTree(?string $menuType = null): Collection
    {
        $cacheKey = 'menus.tree.' . ($menuType ?? 'all');
        
        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($menuType) {
            $query = Menu::active()->roots()->orderBy('order');
            
            if ($menuType) {
                $query->where('menu_type', $menuType);
            }
            
            return $query->with(['activeChildren' => function ($q) {
                $q->orderBy('order')->with(['activeChildren' => function ($q2) {
                    $q2->orderBy('order');
                }]);
            }])->get();
        });
    }

    /**
     * Récupérer les menus par type
     */
    public function getMenusByType(string $type, bool $withChildren = false): Collection
    {
        $cacheKey = "menus.by_type.{$type}." . ($withChildren ? 'with_children' : 'simple');
        
        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($type, $withChildren) {
            $query = Menu::active()->where('type', $type)->orderBy('order');
            
            if ($withChildren) {
                $query->with(['activeChildren' => function ($q) {
                    $q->orderBy('order');
                }]);
            }
            
            return $query->get();
        });
    }

    /**
     * Récupérer les sous-menus d'un menu parent
     */
    public function getChildren(int $parentId, bool $recursive = false): Collection
    {
        $cacheKey = "menus.children.{$parentId}." . ($recursive ? 'recursive' : 'simple');
        
        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($parentId, $recursive) {
            $query = Menu::active()->where('parent_id', $parentId)->orderBy('order');
            
            if ($recursive) {
                $query->with(['activeChildren' => function ($q) {
                    $q->orderBy('order');
                }]);
            }
            
            return $query->get();
        });
    }

    /**
     * Récupérer les menus liés à une catégorie
     */
    public function getMenusByCategory(int $categoryId): Collection
    {
        $cacheKey = "menus.by_category.{$categoryId}";
        
        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($categoryId) {
            return Menu::active()
                ->where('type', 'category')
                ->where('reference_id', $categoryId)
                ->orderBy('order')
                ->get();
        });
    }

    /**
     * Récupérer les menus liés à une activité
     */
    public function getMenusByActivity(int $activityId): Collection
    {
        $cacheKey = "menus.by_activity.{$activityId}";
        
        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($activityId) {
            return Menu::active()
                ->where('type', 'activity')
                ->where('reference_id', $activityId)
                ->orderBy('order')
                ->get();
        });
    }

    /**
     * Rechercher des menus par titre
     */
    public function search(string $query): Collection
    {
        try {
            return Menu::active()
                ->where('title', 'like', "%{$query}%")
                ->orderBy('order')
                ->limit(20)
                ->get();
        } catch (\Exception $e) {
            return collect([]);
        }
    }

    /**
     * Récupérer le fil d'Ariane (breadcrumb) d'un menu
     */
    public function getBreadcrumb($menuId): array
    {
        $menu = is_numeric($menuId) 
            ? Menu::find($menuId) 
            : Menu::where('slug', $menuId)->first();
        
        if (!$menu) {
            return [];
        }
        
        $breadcrumb = [];
        $current = $menu;
        
        while ($current) {
            array_unshift($breadcrumb, [
                'id' => $current->id,
                'title' => $current->final_title,
                'url' => $current->final_url,
                'slug' => $current->slug,
            ]);
            
            $current = $current->parent;
        }
        
        return $breadcrumb;
    }

    /**
     * Récupérer les menus avec pages associées
     */
    public function getMenusWithPages(): Collection
    {
        $cacheKey = 'menus.with_pages';
        
        return Cache::remember($cacheKey, self::CACHE_DURATION, function () {
            return Menu::active()
                ->where('has_page', true)
                ->where('page_status', 'published')
                ->orderBy('order')
                ->get();
        });
    }

    /**
     * Construire un menu HTML
     */
    public function buildHtmlMenu(Collection $menus, int $maxDepth = 2, int $currentDepth = 0): string
    {
        if ($currentDepth >= $maxDepth || $menus->isEmpty()) {
            return '';
        }
        
        $html = '<ul class="menu-level-' . $currentDepth . '">';
        
        foreach ($menus as $menu) {
            $hasChildren = $menu->activeChildren->isNotEmpty();
            $classes = ['menu-item'];
            
            if ($hasChildren) {
                $classes[] = 'has-children';
            }
            
            $html .= '<li class="' . implode(' ', $classes) . '">';
            $html .= '<a href="' . $menu->final_url . '">';
            
            if ($menu->icon) {
                $html .= '<i class="' . $menu->icon . '"></i> ';
            }
            
            $html .= $menu->final_title . '</a>';
            
            if ($hasChildren && $currentDepth < $maxDepth - 1) {
                $html .= $this->buildHtmlMenu($menu->activeChildren, $maxDepth, $currentDepth + 1);
            }
            
            $html .= '</li>';
        }
        
        $html .= '</ul>';
        
        return $html;
    }

    /**
     * Vider le cache des menus
     */
    public function clearCache(): void
    {
        Cache::tags(['menus'])->flush();
    }

    /**
     * Obtenir les statistiques des menus
     */
    public function getStats(): array
    {
        $cacheKey = 'menus.stats';
        
        return Cache::remember($cacheKey, self::CACHE_DURATION, function () {
            return [
                'total_menus' => Menu::active()->count(),
                'root_menus' => Menu::active()->roots()->count(),
                'menus_with_children' => Menu::active()->has('children')->count(),
                'menus_with_pages' => Menu::active()->where('has_page', true)->count(),
                'published_pages' => Menu::active()->where('page_status', 'published')->count(),
            ];
        });
    }
}
