<?php

namespace App\Http\Controllers;

use App\Services\DestinationService;
use Illuminate\Http\Request;

class DestinationPageController extends Controller
{
    protected $destinationService;

    public function __construct(DestinationService $destinationService)
    {
        $this->destinationService = $destinationService;
    }

    /**
     * Afficher la page d'un continent
     */
    public function continent(string $slug)
    {
        $continent = $this->destinationService->getContinentBySlug($slug);
        
        if (!$continent) {
            abort(404, 'Continent non trouvé');
        }

        // Charger les pays du continent
        $countries = $this->destinationService->getCountriesByContinent($continent->id);

        return view('destinations.continent', compact('continent', 'countries'));
    }

    /**
     * Afficher la page d'un pays
     */
    public function country(string $slug)
    {
        $country = $this->destinationService->getCountryBySlug($slug);
        
        if (!$country) {
            abort(404, 'Pays non trouvé');
        }

        // Charger les provinces du pays
        $provinces = $this->destinationService->getProvincesByCountry($country->id);

        return view('destinations.country', compact('country', 'provinces'));
    }

    /**
     * Afficher la page d'une province
     */
    public function province(string $slug)
    {
        $province = $this->destinationService->getProvinceBySlug($slug);
        
        if (!$province) {
            abort(404, 'Province non trouvée');
        }

        // Charger les régions de la province
        $regions = $this->destinationService->getRegionsByProvince($province->id);

        return view('destinations.province', compact('province', 'regions'));
    }

    /**
     * Afficher la page d'une région
     */
    public function region(string $slug)
    {
        $region = $this->destinationService->getRegionBySlug($slug);
        
        if (!$region) {
            abort(404, 'Région non trouvée');
        }

        // Charger les villes de la région
        $villes = $this->destinationService->getVillesByRegion($region->id);

        return view('destinations.region', compact('region', 'villes'));
    }

    /**
     * Afficher la page d'une ville
     */
    public function ville(string $slug)
    {
        $ville = $this->destinationService->getVilleBySlug($slug);
        
        if (!$ville) {
            abort(404, 'Ville non trouvée');
        }

        return view('destinations.ville', compact('ville'));
    }

    /**
     * Afficher la page d'un secteur
     */
    public function secteur(string $slug)
    {
        $secteur = $this->destinationService->getSecteurBySlug($slug);
        
        if (!$secteur) {
            abort(404, 'Secteur non trouvé');
        }

        return view('destinations.secteur', compact('secteur'));
    }

    /**
     * Page d'index des destinations
     */
    public function index()
    {
        $continents = $this->destinationService->getAllContinents();
        
        return view('destinations.index', compact('continents'));
    }
}
