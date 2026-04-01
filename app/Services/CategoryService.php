<?php

namespace App\Services;

use App\Models\Category;
use App\Models\CategorieType;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Collection;

/**
 * Service de gestion des catégories et types de catégories
 * Fournit un accès optimisé avec mise en cache
 */
class CategoryService
{
    /**
     * Durée du cache en secondes (24 heures)
     */
    const CACHE_DURATION = 86400;

    /**
     * Récupérer tous les types de catégories actifs
     */
    public function getCategorieTypes(bool $withCategories = false): Collection
    {
        $cacheKey = 'categories.types.' . ($withCategories ? 'with_categories' : 'simple');
        
        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($withCategories) {
            $query = CategorieType::where('is_active', true)->orderBy('name');
            
            if ($withCategories) {
                $query->with(['categories' => function ($q) {
                    $q->where('is_active', true)->orderBy('name');
                }]);
            }
            
            return $query->get();
        });
    }

    /**
     * Récupérer un type de catégorie par ID ou slug
     */
    public function getCategorieType($identifier, bool $withCategories = false)
    {
        $cacheKey = "categories.type.{$identifier}." . ($withCategories ? 'with_categories' : 'simple');
        
        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($identifier, $withCategories) {
            $query = CategorieType::where('is_active', true);
            
            if ($withCategories) {
                $query->with(['categories' => function ($q) {
                    $q->where('is_active', true)->orderBy('name');
                }]);
            }
            
            return is_numeric($identifier) 
                ? $query->find($identifier)
                : $query->where('slug', $identifier)->first();
        });
    }

    /**
     * Récupérer toutes les catégories actives
     */
    public function getCategories(?int $typeId = null, bool $withRelations = false): Collection
    {
        $cacheKey = 'categories.all.' . ($typeId ?? 'all') . '.' . ($withRelations ? 'with_relations' : 'simple');
        
        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($typeId, $withRelations) {
            $query = Category::where('is_active', true)->orderBy('name');
            
            if ($typeId) {
                $query->where('categorie_type_id', $typeId);
            }
            
            if ($withRelations) {
                $query->with(['type', 'activities']);
            }
            
            return $query->get();
        });
    }

    /**
     * Récupérer une catégorie par ID ou slug
     */
    public function getCategory($identifier, bool $withRelations = false)
    {
        $cacheKey = "categories.category.{$identifier}." . ($withRelations ? 'with_relations' : 'simple');
        
        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($identifier, $withRelations) {
            $query = Category::where('is_active', true);
            
            if ($withRelations) {
                $query->with(['type', 'activities' => function ($q) {
                    $q->where('is_active', true);
                }]);
            }
            
            return is_numeric($identifier) 
                ? $query->find($identifier)
                : $query->where('slug', $identifier)->first();
        });
    }

    /**
     * Rechercher des catégories par nom
     */
    public function search(string $query, ?int $typeId = null): Collection
    {
        try {
            $queryBuilder = Category::where('is_active', true)
                ->where('name', 'like', "%{$query}%");
            
            if ($typeId) {
                $queryBuilder->where('categorie_type_id', $typeId);
            }
            
            return $queryBuilder->with('type')->limit(20)->get();
        } catch (\Exception $e) {
            return collect([]);
        }
    }

    /**
     * Récupérer les catégories par type (slug du type)
     */
    public function getCategoriesByTypeSlug(string $typeSlug, bool $withRelations = false): Collection
    {
        $type = $this->getCategorieType($typeSlug);
        
        if (!$type) {
            return collect([]);
        }
        
        return $this->getCategories($type->id, $withRelations);
    }

    /**
     * Récupérer les catégories populaires (avec le plus d'activités)
     */
    public function getPopularCategories(int $limit = 10): Collection
    {
        $cacheKey = "categories.popular.{$limit}";
        
        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($limit) {
            return Category::where('is_active', true)
                ->withCount('activities')
                ->orderBy('activities_count', 'desc')
                ->limit($limit)
                ->get();
        });
    }

    /**
     * Grouper les catégories par type
     */
    public function getCategoriesGroupedByType(): Collection
    {
        $cacheKey = 'categories.grouped_by_type';
        
        return Cache::remember($cacheKey, self::CACHE_DURATION, function () {
            return CategorieType::where('is_active', true)
                ->with(['categories' => function ($q) {
                    $q->where('is_active', true)->orderBy('name');
                }])
                ->orderBy('name')
                ->get();
        });
    }

    /**
     * Vider le cache des catégories
     */
    public function clearCache(): void
    {
        Cache::tags(['categories'])->flush();
    }

    /**
     * Obtenir les statistiques des catégories
     */
    public function getStats(): array
    {
        $cacheKey = 'categories.stats';
        
        return Cache::remember($cacheKey, self::CACHE_DURATION, function () {
            return [
                'total_types' => CategorieType::where('is_active', true)->count(),
                'total_categories' => Category::where('is_active', true)->count(),
                'categories_with_activities' => Category::where('is_active', true)
                    ->has('activities')
                    ->count(),
                'most_popular_category' => Category::where('is_active', true)
                    ->withCount('activities')
                    ->orderBy('activities_count', 'desc')
                    ->first(),
            ];
        });
    }
}
