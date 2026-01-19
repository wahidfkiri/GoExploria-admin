<?php

namespace Vendor\Destination\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Continent;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ContinentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Continent::withCount('countries');
        
        // Recherche
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Filtres
        if ($request->has('sort_by') && !empty($request->sort_by)) {
            $query->orderBy($request->sort_by, $request->sort_direction ?? 'asc');
        } else {
            $query->orderBy('name');
        }
        
        // Si requête AJAX
        if ($request->ajax()) {
            $continents = $query->paginate(10);
            
            return response()->json([
                'success' => true,
                'data' => $continents->items(),
                'current_page' => $continents->currentPage(),
                'last_page' => $continents->lastPage(),
                'per_page' => $continents->perPage(),
                'total' => $continents->total(),
                'prev_page_url' => $continents->previousPageUrl(),
                'next_page_url' => $continents->nextPageUrl(),
            ]);
        }
        
        // Pour la vue normale
        $continents = $query->paginate(10);
        return view('destination::continents.index', compact('continents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('destination::continents.create');
    }

    /**
     * Store a newly created resource in storage.
     */
  public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255|unique:continents',
        'code' => 'required|string|max:2|unique:continents',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        'description' => 'nullable|string',
        'population' => 'nullable|integer|min:0',
        'area' => 'nullable|numeric|min:0',
        'countries_count' => 'nullable|integer|min:0',
        'languages' => 'nullable|array',
    ]);

    // Gestion de l'upload de l'image
    if ($request->hasFile('image')) {
        $imageName = time() . '_' . uniqid() . '.' . $request->image->extension();
        
        // Stocker dans le dossier public
        $path = $request->file('image')->storeAs('continents', $imageName, 'public');
        
        $validated['image'] = $imageName;
        
        \Log::info('Image stored at: ' . $path);
    }

    // Convertir les langues en JSON si fournies
    if ($request->has('languages')) {
        $validated['languages'] = json_encode($validated['languages']);
    }

    $continent = Continent::create($validated);

    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'message' => 'Continent créé avec succès!',
            'data' => $continent
        ]);
    }

    return redirect()->route('continents.index')
        ->with('success', 'Continent créé avec succès!');
}

    /**
     * Display the specified resource.
     */
    public function show(Continent $continent)
    {
        $continent->load(['countries' => function($query) {
            $query->orderBy('name')->limit(20);
        }]);
        
        
        
        return view('destination::countries.index', compact('continent'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Continent $continent)
    {
        return view('continents.edit', compact('continent'));
    }

    /**
     * Update the specified resource in storage.
     */

public function update(Request $request, Continent $continent)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255|unique:continents,name,' . $continent->id,
        'code' => 'required|string|max:2|unique:continents,code,' . $continent->id,
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        'description' => 'nullable|string',
        'population' => 'nullable|integer|min:0',
        'area' => 'nullable|numeric|min:0',
        'countries_count' => 'nullable|integer|min:0',
        'languages' => 'nullable|array',
    ]);

    // Gestion de l'upload de l'image
    if ($request->hasFile('image')) {
        // Supprimer l'ancienne image si elle existe
        if ($continent->image && Storage::disk('public')->exists('continents/' . $continent->image)) {
            Storage::disk('public')->delete('continents/' . $continent->image);
        }
        
        // Uploader la nouvelle image
        $imageName = time() . '_' . uniqid() . '.' . $request->image->extension();
        
        // Stocker dans le dossier public
        $path = $request->file('image')->storeAs('continents', $imageName, 'public');
        
        $validated['image'] = $imageName;
        
        \Log::info('Image stored at: ' . $path);
        \Log::info('Full path: ' . storage_path('app/public/' . $path));
    } 
    // Si la case "supprimer l'image" est cochée
    elseif ($request->has('remove_image') && $request->remove_image == '1') {
        // Supprimer l'image du stockage
        if ($continent->image && Storage::disk('public')->exists('continents/' . $continent->image)) {
            Storage::disk('public')->delete('continents/' . $continent->image);
        }
        $validated['image'] = null;
    }
    // Sinon, garder l'image existante
    else {
        unset($validated['image']);
    }

    // Convertir les langues en JSON si fournies
    if ($request->has('languages')) {
        $validated['languages'] = json_encode($validated['languages']);
    }

    $continent->update($validated);

    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'message' => 'Continent mis à jour avec succès!',
            'data' => $continent
        ]);
    }

    return redirect()->route('continents.index')
        ->with('success', 'Continent mis à jour avec succès!');
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Continent $continent)
    {
        try {
            DB::beginTransaction();
            
            // Supprimer les pays associés
            $continent->countries()->delete();
            
            // Supprimer le continent
            $continent->delete();
            
            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Continent supprimé avec succès!'
                ]);
            }

            return redirect()->route('continents.index')
                ->with('success', 'Continent supprimé avec succès!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de la suppression du continent: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('continents.index')
                ->with('error', 'Erreur lors de la suppression du continent: ' . $e->getMessage());
        }
    }

    /**
     * Get statistics for dashboard
     */
    public function getStatistics()
    {
        $stats = [
            'total_continents' => Continent::count(),
            'total_population' => Continent::sum('population'),
            'total_area' => Continent::sum('area'),
            'total_countries' => Continent::sum('countries_count'),
            'most_populous' => Continent::orderBy('population', 'desc')->first(),
            'largest' => Continent::orderBy('area', 'desc')->first(),
            'smallest' => Continent::where('area', '>', 0)->orderBy('area')->first(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * Get countries for a specific continent
     */
    public function getCountries(Continent $continent)
    {
        $countries = $continent->countries()
            ->orderBy('name')
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $countries
        ]);
    }
}