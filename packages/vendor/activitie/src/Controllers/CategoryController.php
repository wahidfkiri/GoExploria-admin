<?php

namespace Vendor\Activitie\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Category::withCount(['websites', 'templates']);
        
        // Recherche
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Filtre par statut
        if ($request->has('status') && $request->status !== '') {
            $query->where('is_active', $request->status === 'active');
        }
        
        // Tri
        if ($request->has('sort_by') && !empty($request->sort_by)) {
            $sortable = ['name', 'websites_count', 'templates_count', 'created_at'];
            if (in_array($request->sort_by, $sortable)) {
                $query->orderBy($request->sort_by, $request->sort_direction ?? 'asc');
            }
        } else {
            $query->orderBy('name');
        }
        
        // Si requête AJAX
        if ($request->ajax()) {
            $perPage = $request->per_page ?? 10;
            $categories = $query->paginate($perPage);
            
            return response()->json([
                'success' => true,
                'data' => $categories->items(),
                'current_page' => $categories->currentPage(),
                'last_page' => $categories->lastPage(),
                'per_page' => $categories->perPage(),
                'total' => $categories->total(),
                'prev_page_url' => $categories->previousPageUrl(),
                'next_page_url' => $categories->nextPageUrl(),
            ]);
        }
        
        // Pour la vue normale
        $categories = $query->paginate(10);
        
        return view('activitie::categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('activitie::categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        // Générer le slug automatiquement
        $validated['slug'] = Str::slug($validated['name']);
        
        $category = Category::create($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Catégorie créée avec succès!',
                'data' => $category
            ]);
        }

        return redirect()->route('categories.index')
            ->with('success', 'Catégorie créée avec succès!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $category->load(['websites' => function($query) {
            $query->orderBy('name')->limit(10);
        }, 'templates' => function($query) {
            $query->orderBy('name')->limit(10);
        }]);
        
        $statistics = [
            'websites_count' => $category->websites_count,
            'templates_count' => $category->templates_count,
            'total_items' => $category->websites_count + $category->templates_count,
        ];
        
        return view('categories.show', compact('category', 'statistics'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        // Mettre à jour le slug si le nom change
        if ($category->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $category->update($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Catégorie mise à jour avec succès!',
                'data' => $category
            ]);
        }

        return redirect()->route('categories.index')
            ->with('success', 'Catégorie mise à jour avec succès!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Category $category)
    {
        try {
            DB::beginTransaction();
            
            // Vérifier si la catégorie est utilisée
            if ($category->websites()->count() > 0 || $category->templates()->count() > 0) {
                throw new \Exception('Cette catégorie ne peut pas être supprimée car elle est utilisée par des sites web ou des templates.');
            }
            
            // Supprimer la catégorie
            $category->delete();
            
            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Catégorie supprimée avec succès!'
                ]);
            }

            return redirect()->route('categories.index')
                ->with('success', 'Catégorie supprimée avec succès!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de la suppression: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('categories.index')
                ->with('error', 'Erreur lors de la suppression: ' . $e->getMessage());
        }
    }

    /**
     * Get statistics for dashboard
     */
    /**
 * Get statistics for dashboard
 */
public function getStatistics(Request $request)
{
    try {
        // D'abord, récupérons les catégories avec les comptages
        $categoriesWithCounts = Category::withCount(['websites', 'templates'])->get();
        
        // Calculer les statistiques
        $mostUsed = null;
        $leastUsed = null;
        $maxCount = -1;
        $minCount = PHP_INT_MAX;
        
        foreach ($categoriesWithCounts as $category) {
            $totalCount = $category->websites_count + $category->templates_count;
            
            if ($totalCount > $maxCount) {
                $maxCount = $totalCount;
                $mostUsed = $category;
            }
            
            if ($totalCount < $minCount) {
                $minCount = $totalCount;
                $leastUsed = $category;
            }
        }
        
        // Pour categories_by_usage, nous trions manuellement
        $sortedCategories = $categoriesWithCounts->sortByDesc(function($category) {
            return $category->websites_count + $category->templates_count;
        })->take(10);
        
        $stats = [
            'total_categories' => Category::count(),
            'active_categories' => Category::where('is_active', true)->count(),
            'inactive_categories' => Category::where('is_active', false)->count(),
            'categories_with_websites' => Category::has('websites')->count(),
            'categories_with_templates' => Category::has('templates')->count(),
            'most_used' => $mostUsed ? [
                'name' => $mostUsed->name,
                'slug' => $mostUsed->slug,
                'websites_count' => $mostUsed->websites_count,
                'templates_count' => $mostUsed->templates_count,
                'total_items' => $mostUsed->websites_count + $mostUsed->templates_count,
            ] : null,
            'least_used' => $leastUsed ? [
                'name' => $leastUsed->name,
                'slug' => $leastUsed->slug,
                'websites_count' => $leastUsed->websites_count,
                'templates_count' => $leastUsed->templates_count,
                'total_items' => $leastUsed->websites_count + $leastUsed->templates_count,
            ] : null,
            'total_websites_in_categories' => $categoriesWithCounts->sum('websites_count'),
            'total_templates_in_categories' => $categoriesWithCounts->sum('templates_count'),
            'categories_by_usage' => $sortedCategories->map(function($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'websites_count' => $category->websites_count,
                    'templates_count' => $category->templates_count,
                    'total_items' => $category->websites_count + $category->templates_count,
                ];
            })->values(),
            'latest_categories' => Category::orderBy('created_at', 'desc')
                ->limit(5)
                ->get()
                ->map(function($category) {
                    return [
                        'id' => $category->id,
                        'name' => $category->name,
                        'slug' => $category->slug,
                        'created_at' => $category->created_at->format('d/m/Y H:i'),
                    ];
                }),
            'categories_without_items' => Category::doesntHave('websites')->doesntHave('templates')->count(),
        ];

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $stats,
                'message' => 'Statistiques des catégories récupérées avec succès'
            ]);
        }

        return $stats;

    } catch (\Exception $e) {
        \Log::error('Erreur dans getStatistics: ' . $e->getMessage());
        
        $errorResponse = [
            'success' => false,
            'message' => 'Erreur lors du calcul des statistiques',
            'error' => $e->getMessage()
        ];

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json($errorResponse, 500);
        }

        return $errorResponse;
    }
}

    /**
     * Search categories (autocomplete)
     */
    public function search(Request $request)
    {
        $query = $request->input('q');
        
        $categories = Category::where('name', 'like', "%{$query}%")
            ->orWhere('slug', 'like', "%{$query}%")
            ->limit(10)
            ->get(['id', 'name', 'slug', 'is_active']);
            
        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }

    /**
     * Get categories for dropdown
     */
    public function getForDropdown()
    {
        $categories = Category::where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'slug']);

        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }

    /**
     * Toggle category status
     */
    public function toggleStatus(Request $request, Category $category)
    {
        try {
            $category->update([
                'is_active' => !$category->is_active
            ]);

            $status = $category->is_active ? 'activée' : 'désactivée';

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Catégorie ' . $status . ' avec succès!',
                    'data' => $category
                ]);
            }

            return redirect()->route('categories.index')
                ->with('success', 'Catégorie ' . $status . ' avec succès!');

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors du changement de statut: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('categories.index')
                ->with('error', 'Erreur lors du changement de statut: ' . $e->getMessage());
        }
    }

    /**
     * Export categories data
     */
    public function export(Request $request)
    {
        $categories = Category::withCount(['websites', 'templates'])
            ->orderBy('name')
            ->get();

        // Logique d'export CSV, Excel, etc.
        if ($request->format === 'csv') {
            return response()->json([
                'success' => true,
                'message' => 'Export CSV non implémenté',
                'data' => $categories
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $categories,
            'total' => $categories->count()
        ]);
    }

    /**
     * Bulk update categories
     */
    public function bulkUpdate(Request $request)
    {
        try {
            $validated = $request->validate([
                'ids' => 'required|array',
                'ids.*' => 'exists:categories,id',
                'action' => 'required|in:activate,deactivate,delete',
            ]);

            $count = 0;
            $message = '';

            switch ($validated['action']) {
                case 'activate':
                    Category::whereIn('id', $validated['ids'])->update(['is_active' => true]);
                    $count = count($validated['ids']);
                    $message = $count . ' catégorie(s) activée(s) avec succès!';
                    break;
                    
                case 'deactivate':
                    Category::whereIn('id', $validated['ids'])->update(['is_active' => false]);
                    $count = count($validated['ids']);
                    $message = $count . ' catégorie(s) désactivée(s) avec succès!';
                    break;
                    
                case 'delete':
                    // Vérifier qu'aucune catégorie n'est utilisée
                    $usedCategories = Category::whereIn('id', $validated['ids'])
                        ->where(function($query) {
                            $query->has('websites')->orHas('templates');
                        })
                        ->count();
                        
                    if ($usedCategories > 0) {
                        throw new \Exception('Certaines catégories ne peuvent pas être supprimées car elles sont utilisées.');
                    }
                    
                    Category::whereIn('id', $validated['ids'])->delete();
                    $count = count($validated['ids']);
                    $message = $count . ' catégorie(s) supprimée(s) avec succès!';
                    break;
            }

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'count' => $count
                ]);
            }

            return redirect()->route('categories.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de l\'opération en masse: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('categories.index')
                ->with('error', 'Erreur lors de l\'opération en masse: ' . $e->getMessage());
        }
    }
}