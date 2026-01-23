<?php

namespace Vendor\Destination\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Continent;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Country::with(['continent', 'provinces'])
            ->withCount('provinces');
        
        // Recherche
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('iso2', 'like', "%{$search}%")
                  ->orWhere('capital', 'like', "%{$search}%")
                  ->orWhere('currency', 'like', "%{$search}%");
            });
        }
        
        // Filtre par continent
        if ($request->has('continent') && !empty($request->continent)) {
            $query->whereHas('continent', function($q) use ($request) {
                $q->where('code', $request->continent)
                  ->orWhere('name', 'like', "%{$request->continent}%");
            });
        }
        
        // Filtre par région
        if ($request->has('region') && !empty($request->region)) {
            $query->where('region', 'like', "%{$request->region}%");
        }
        
        // Tri
        if ($request->has('sort_by') && !empty($request->sort_by)) {
            $sortable = ['name', 'code', 'population', 'area', 'created_at'];
            if (in_array($request->sort_by, $sortable)) {
                $query->orderBy($request->sort_by, $request->sort_direction ?? 'asc');
            }
        } else {
            $query->orderBy('name');
        }
        
        // Si requête AJAX
        if ($request->ajax()) {
            $perPage = $request->per_page ?? 10;
            $countries = $query->paginate($perPage);
            
            return response()->json([
                'success' => true,
                'data' => $countries->items(),
                'current_page' => $countries->currentPage(),
                'last_page' => $countries->lastPage(),
                'per_page' => $countries->perPage(),
                'total' => $countries->total(),
                'prev_page_url' => $countries->previousPageUrl(),
                'next_page_url' => $countries->nextPageUrl(),
            ]);
        }
        
        // Pour la vue normale
        $countries = $query->paginate(10);
        $continents = Continent::orderBy('name')->get();
        
        return view('destination::countries.index', compact('countries', 'continents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $continents = Continent::orderBy('name')->get();
        return view('countries.create', compact('continents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:countries',
            'code' => 'required|string|max:3|unique:countries',
            'iso2' => 'nullable|string|max:2|unique:countries',
            'phone_code' => 'nullable|string|max:10',
            'capital' => 'nullable|string|max:255',
            'currency' => 'nullable|string|max:100',
            'currency_symbol' => 'nullable|string|max:10',
            'flag' => 'nullable|string|max:255',
            'latitude' => 'nullable|string|max:20',
            'longitude' => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'population' => 'nullable|integer|min:0',
            'area' => 'nullable|numeric|min:0',
            'official_language' => 'nullable|string|max:255',
            'timezones' => 'nullable|array',
            'region' => 'nullable|string|max:255',
            'continent_id' => 'required|exists:continents,id',
        ]);

        // Convertir les timezones en JSON si fournies
        if ($request->has('timezones')) {
            $validated['timezones'] = json_encode($validated['timezones']);
        }

        $country = Country::create($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Pays créé avec succès!',
                'data' => $country->load('continent')
            ]);
        }

        return redirect()->route('countries.index')
            ->with('success', 'Pays créé avec succès!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Country $country)
    {
        $country->load(['continent', 'provinces' => function($query) {
            $query->orderBy('name');
        }]);
        
        $statistics = [
            'total_provinces' => $country->provinces_count,
            'total_population' => $country->provinces()->sum('population'),
            'total_area' => $country->provinces()->sum('area'),
            'most_populous_province' => $country->provinces()->orderBy('population', 'desc')->first(),
            'largest_province' => $country->provinces()->orderBy('area', 'desc')->first(),
        ];
        
        return view('countries.show', compact('country', 'statistics'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Country $country)
    {
        $continents = Continent::orderBy('name')->get();
        return view('countries.edit', compact('country', 'continents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Country $country)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:countries,name,' . $country->id,
            'code' => 'required|string|max:3|unique:countries,code,' . $country->id,
            'iso2' => 'nullable|string|max:2|unique:countries,iso2,' . $country->id,
            'phone_code' => 'nullable|string|max:10',
            'capital' => 'nullable|string|max:255',
            'currency' => 'nullable|string|max:100',
            'currency_symbol' => 'nullable|string|max:10',
            'flag' => 'nullable|string|max:255',
            'latitude' => 'nullable|string|max:20',
            'longitude' => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'population' => 'nullable|integer|min:0',
            'area' => 'nullable|numeric|min:0',
            'official_language' => 'nullable|string|max:255',
            'timezones' => 'nullable|array',
            'region' => 'nullable|string|max:255',
            'continent_id' => 'required|exists:continents,id',
        ]);

        // Convertir les timezones en JSON si fournies
        if ($request->has('timezones')) {
            $validated['timezones'] = json_encode($validated['timezones']);
        } elseif ($request->has('timezones') && empty($request->timezones)) {
            $validated['timezones'] = null;
        }

        $country->update($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Pays mis à jour avec succès!',
                'data' => $country->load('continent')
            ]);
        }

        return redirect()->route('countries.index')
            ->with('success', 'Pays mis à jour avec succès!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Country $country)
    {
        try {
            DB::beginTransaction();
            
            // Supprimer les provinces associées
            $country->provinces()->delete();
            
            // Supprimer le pays
            $country->delete();
            
            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pays supprimé avec succès!'
                ]);
            }

            return redirect()->route('countries.index')
                ->with('success', 'Pays supprimé avec succès!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de la suppression du pays: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('countries.index')
                ->with('error', 'Erreur lors de la suppression du pays: ' . $e->getMessage());
        }
    }

    /**
     * Get statistics for dashboard
     */
    public function getStatistics(Request $request)
    {
        try {
            $stats = [
                'total_countries' => Country::count(),
                'total_population' => (int)Country::sum('population'),
                'total_area' => (float)Country::sum('area'),
                'by_continent' => Continent::withCount('countries')
                    ->withSum('countries', 'population')
                    ->withSum('countries', 'area')
                    ->orderBy('countries_sum_population', 'desc')
                    ->get()
                    ->map(function($continent) {
                        return [
                            'id' => $continent->id,
                            'name' => $continent->name,
                            'code' => $continent->code,
                            'countries_count' => $continent->countries_count,
                            'total_population' => $continent->countries_sum_population,
                            'total_area' => $continent->countries_sum_area,
                        ];
                    }),
                'most_populous' => Country::with('continent')
                    ->select('name', 'code', 'continent_id', 'population')
                    ->orderBy('population', 'desc')
                    ->first(),
                'largest' => Country::with('continent')
                    ->select('name', 'code', 'continent_id', 'area')
                    ->orderBy('area', 'desc')
                    ->first(),
                'smallest' => Country::with('continent')
                    ->select('name', 'code', 'continent_id', 'area')
                    ->where('area', '>', 0)
                    ->orderBy('area', 'asc')
                    ->first(),
                'average_population' => (int)Country::avg('population'),
                'average_area' => (float)Country::avg('area'),
                'regions' => Country::select('region')
                    ->whereNotNull('region')
                    ->distinct()
                    ->count(),
            ];

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => $stats,
                    'message' => 'Statistiques des pays récupérées avec succès'
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
     * Get provinces for a specific country
     */
    public function getProvinces(Country $country)
    {
        $provinces = $country->provinces()
            ->orderBy('name')
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $provinces
        ]);
    }

    /**
     * Get countries by continent
     */
    public function getByContinent($continentCode)
    {
        $countries = Country::whereHas('continent', function($query) use ($continentCode) {
            $query->where('code', $continentCode);
        })
        ->orderBy('name')
        ->get();

        return response()->json([
            'success' => true,
            'data' => $countries
        ]);
    }

    /**
     * Search countries (autocomplete)
     */
    public function search(Request $request)
    {
        $query = $request->input('q');
        
        $countries = Country::where('name', 'like', "%{$query}%")
            ->orWhere('code', 'like', "%{$query}%")
            ->orWhere('iso2', 'like', "%{$query}%")
            ->limit(10)
            ->get(['id', 'name', 'code', 'iso2', 'flag']);
            
        return response()->json([
            'success' => true,
            'data' => $countries
        ]);
    }

    public function toggleStatus(Request $request, Country $country)
{
    try {
        \Log::info('ToggleStatus Country - Début', [
            'country_id' => $country->id,
            'country_name' => $country->name,
            'input_data' => $request->all(),
            'current_status' => $country->is_active
        ]);
        
        $validated = $request->validate([
            'is_active' => 'required'
        ]);
        
        \Log::info('ToggleStatus Country - Données validées', [
            'validated_data' => $validated,
            'validated_is_active_type' => gettype($validated['is_active']),
            'validated_is_active_value' => $validated['is_active']
        ]);
        
        // Déterminer la nouvelle valeur
        $newStatus = false;
        
        if ($validated['is_active'] === true || 
            $validated['is_active'] === 'true' || 
            $validated['is_active'] === 1 || 
            $validated['is_active'] === '1') {
            $newStatus = true;
        }
        
        \Log::info('ToggleStatus Country - Nouveau statut déterminé', [
            'new_status_bool' => $newStatus,
            'new_status_int' => $newStatus ? 1 : 0
        ]);
        
        // Mettre à jour le pays
        $country->update([
            'is_active' => $newStatus ? 1 : 0
        ]);
        
        // Recharger le modèle pour vérifier
        $country->refresh();
        
        \Log::info('ToggleStatus Country - Mise à jour réussie', [
            'updated_status' => $country->is_active,
            'updated_at' => $country->updated_at
        ]);
        
        return response()->json([
            'success' => true,
            'message' => $newStatus ? 'Pays activé avec succès' : 'Pays désactivé avec succès',
            'data' => $country
        ]);
        
    } catch (\Exception $e) {
        \Log::error('ToggleStatus Country - Erreur', [
            'country_id' => $country->id ?? 'N/A',
            'error_message' => $e->getMessage(),
            'error_trace' => $e->getTraceAsString(),
            'request_data' => $request->all()
        ]);
        
        return response()->json([
            'success' => false,
            'message' => 'Erreur lors de la mise à jour du statut: ' . $e->getMessage(),
            'error' => $e->getMessage()
        ], 500);
    }
}
}