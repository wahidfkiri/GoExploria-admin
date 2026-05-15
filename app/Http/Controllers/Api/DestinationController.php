<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\DestinationService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * API Controller pour les destinations géographiques
 * Fournit des endpoints RESTful en lecture seule
 */
class DestinationController extends Controller
{
    protected DestinationService $destinationService;

    public function __construct(DestinationService $destinationService)
    {
        $this->destinationService = $destinationService;
    }

    /**
     * GET /api/destinations/continents
     * Récupérer tous les continents
     */
    public function continents(Request $request): JsonResponse
    {
        $withRelations = $request->boolean('with_relations', false);
        $continents = $this->destinationService->getContinents($withRelations);

        return response()->json([
            'success' => true,
            'data' => $continents,
            'count' => $continents->count()
        ]);
    }

    /**
     * GET /api/destinations/continents/{identifier}
     * Récupérer un continent par ID ou code
     */
    public function continent(Request $request, $identifier): JsonResponse
    {
        $withRelations = $request->boolean('with_relations', false);
        $continent = $this->destinationService->getContinent($identifier, $withRelations);

        if (!$continent) {
            return response()->json([
                'success' => false,
                'message' => 'Continent non trouvé'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $continent
        ]);
    }

    /**
     * GET /api/destinations/countries
     * Récupérer tous les pays (optionnel: filtrer par continent)
     */
    public function countries(Request $request): JsonResponse
    {
        $continentId = $request->input('continent_id');
        $withRelations = $request->boolean('with_relations', false);
        
        $countries = $this->destinationService->getCountries($continentId, $withRelations);

        return response()->json([
            'success' => true,
            'data' => $countries,
            'count' => $countries->count()
        ]);
    }

    /**
     * GET /api/destinations/countries/{identifier}
     * Récupérer un pays par ID ou code
     */
    public function country(Request $request, $identifier): JsonResponse
    {
        $withRelations = $request->boolean('with_relations', false);
        $country = $this->destinationService->getCountry($identifier, $withRelations);

        if (!$country) {
            return response()->json([
                'success' => false,
                'message' => 'Pays non trouvé'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $country
        ]);
    }

    /**
     * GET /api/destinations/provinces
     * Récupérer toutes les provinces (optionnel: filtrer par pays)
     */
    public function provinces(Request $request): JsonResponse
    {
        $countryId = $request->input('country_id');
        $withRelations = $request->boolean('with_relations', false);
        
        $provinces = $this->destinationService->getProvinces($countryId, $withRelations);

        return response()->json([
            'success' => true,
            'data' => $provinces,
            'count' => $provinces->count()
        ]);
    }

    /**
     * GET /api/destinations/provinces/{identifier}
     * Récupérer une province par ID ou code
     */
    public function province(Request $request, $identifier): JsonResponse
    {
        $withRelations = $request->boolean('with_relations', false);
        $province = $this->destinationService->getProvince($identifier, $withRelations);

        if (!$province) {
            return response()->json([
                'success' => false,
                'message' => 'Province non trouvée'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $province
        ]);
    }

    /**
     * GET /api/destinations/regions
     * Récupérer toutes les régions (optionnel: filtrer par province)
     */
    public function regions(Request $request): JsonResponse
    {
        $provinceId = $request->input('province_id');
        $withRelations = $request->boolean('with_relations', false);
        
        $regions = $this->destinationService->getRegions($provinceId, $withRelations);

        return response()->json([
            'success' => true,
            'data' => $regions,
            'count' => $regions->count()
        ]);
    }

    /**
     * GET /api/destinations/regions/{identifier}
     * Récupérer une région par ID ou code
     */
    public function region(Request $request, $identifier): JsonResponse
    {
        $withRelations = $request->boolean('with_relations', false);
        $region = $this->destinationService->getRegion($identifier, $withRelations);

        if (!$region) {
            return response()->json([
                'success' => false,
                'message' => 'Région non trouvée'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $region
        ]);
    }

    /**
     * GET /api/destinations/villes
     * Récupérer toutes les villes (optionnel: filtrer par région)
     */
    public function villes(Request $request): JsonResponse
    {
        $regionId = $request->input('region_id');
        $withRelations = $request->boolean('with_relations', false);
        
        $villes = $this->destinationService->getVilles($regionId, $withRelations);

        return response()->json([
            'success' => true,
            'data' => $villes,
            'count' => $villes->count()
        ]);
    }

    /**
     * GET /api/destinations/villes/{identifier}
     * Récupérer une ville par ID ou code
     */
    public function ville(Request $request, $identifier): JsonResponse
    {
        $withRelations = $request->boolean('with_relations', false);
        $ville = $this->destinationService->getVille($identifier, $withRelations);

        if (!$ville) {
            return response()->json([
                'success' => false,
                'message' => 'Ville non trouvée'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $ville
        ]);
    }

    /**
     * GET /api/destinations/secteurs
     * Récupérer tous les secteurs (optionnel: filtrer par région)
     */
    public function secteurs(Request $request): JsonResponse
    {
        $regionId = $request->input('region_id');
        $withRelations = $request->boolean('with_relations', false);
        
        $secteurs = $this->destinationService->getSecteurs($regionId, $withRelations);

        return response()->json([
            'success' => true,
            'data' => $secteurs,
            'count' => $secteurs->count()
        ]);
    }

    /**
     * GET /api/destinations/secteurs/{identifier}
     * Récupérer un secteur par ID ou code
     */
    public function secteur(Request $request, $identifier): JsonResponse
    {
        $withRelations = $request->boolean('with_relations', false);
        $secteur = $this->destinationService->getSecteur($identifier, $withRelations);

        if (!$secteur) {
            return response()->json([
                'success' => false,
                'message' => 'Secteur non trouvé'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $secteur
        ]);
    }

    /**
     * GET /api/destinations/search
     * Rechercher des destinations par nom
     */
    public function search(Request $request): JsonResponse
    {
        $request->validate([
            'query' => 'required|string|min:2',
            'type' => 'nullable|in:continent,country,province,region,ville,secteur,etablissement'
        ]);

        $results = $this->destinationService->search(
            $request->input('query'),
            $request->input('type')
        );

        return response()->json([
            'success' => true,
            'data' => $results,
            'query' => $request->input('query')
        ]);
    }

    /**
     * GET /api/destinations/hierarchy/{type}/{identifier}
     * Récupérer la hiérarchie complète d'une destination
     */
    public function hierarchy(string $type, $identifier): JsonResponse
    {
        $validTypes = ['ville', 'secteur', 'region', 'province', 'country'];
        
        if (!in_array($type, $validTypes)) {
            return response()->json([
                'success' => false,
                'message' => 'Type invalide. Types valides: ' . implode(', ', $validTypes)
            ], 400);
        }

        $hierarchy = $this->destinationService->getHierarchy($type, $identifier);

        if (!$hierarchy) {
            return response()->json([
                'success' => false,
                'message' => ucfirst($type) . ' non trouvé(e)'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $hierarchy
        ]);
    }

    /**
     * GET /api/destinations/continents/{identifier}/countries
     * Récupérer les pays d'un continent
     */
    public function countriesByContinent(Request $request, $identifier): JsonResponse
    {
        $withRelations = $request->boolean('with_relations', false);
        $countries = $this->destinationService->getCountriesByContinent($identifier, $withRelations);

        return response()->json([
            'success' => true,
            'data' => $countries,
            'count' => $countries->count()
        ]);
    }

    /**
     * GET /api/destinations/countries/{identifier}/provinces
     * Récupérer les provinces d'un pays
     */
    public function provincesByCountry(Request $request, $identifier): JsonResponse
    {
        $withRelations = $request->boolean('with_relations', false);
        $provinces = $this->destinationService->getProvincesByCountry($identifier, $withRelations);

        return response()->json([
            'success' => true,
            'data' => $provinces,
            'count' => $provinces->count()
        ]);
    }

    /**
     * GET /api/destinations/provinces/{identifier}/regions
     * Récupérer les régions d'une province
     */
    public function regionsByProvince(Request $request, $identifier): JsonResponse
    {
        $withRelations = $request->boolean('with_relations', false);
        $regions = $this->destinationService->getRegionsByProvince($identifier, $withRelations);

        return response()->json([
            'success' => true,
            'data' => $regions,
            'count' => $regions->count()
        ]);
    }

    /**
     * GET /api/destinations/regions/{identifier}/villes
     * Récupérer les villes d'une région
     */
    public function villesByRegion(Request $request, $identifier): JsonResponse
    {
        $withRelations = $request->boolean('with_relations', false);
        $villes = $this->destinationService->getVillesByRegion($identifier, $withRelations);

        return response()->json([
            'success' => true,
            'data' => $villes,
            'count' => $villes->count()
        ]);
    }

    /**
     * GET /api/destinations/villes/{identifier}/secteurs
     * Récupérer les secteurs d'une ville
     */
    public function secteursByVille(Request $request, $identifier): JsonResponse
    {
        $withRelations = $request->boolean('with_relations', false);
        $secteurs = $this->destinationService->getSecteursByVille($identifier, $withRelations);

        return response()->json([
            'success' => true,
            'data' => $secteurs,
            'count' => $secteurs->count()
        ]);
    }
}
