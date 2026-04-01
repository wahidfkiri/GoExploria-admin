<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    /**
     * Afficher la page Expériences Québec
     */
    public function experiencesQuebec()
    {
        return view('landing.experiences-quebec', [
            'title' => 'Expériences Québec',
            'description' => 'Découvrez les meilleures activités et expériences au Québec'
        ]);
    }

    /**
     * Afficher la page Expériences Canada
     */
    public function experiencesCanada()
    {
        return view('landing.experiences-canada', [
            'title' => 'Expériences Canada',
            'description' => 'Voyages et découvertes à travers le Canada'
        ]);
    }

    /**
     * Afficher la page Expériences Régional
     */
    public function experiencesRegional()
    {
        return view('landing.experiences-regional', [
            'title' => 'Expériences Régional',
            'description' => 'Explorez les trésors de votre région'
        ]);
    }

    /**
     * Afficher la page Transport Aérien
     */
    public function transportAerien()
    {
        return view('landing.transport-aerien', [
            'title' => 'Transport Aérien',
            'description' => 'Réservez vos vols et billets d\'avion'
        ]);
    }

    /**
     * Afficher la page Transport Terrestre
     */
    public function transportTerrestre()
    {
        return view('landing.transport-terrestre', [
            'title' => 'Transport Terrestre',
            'description' => 'Bus, train et location de véhicules'
        ]);
    }

    /**
     * Afficher la page Transport Maritime
     */
    public function transportMaritime()
    {
        return view('landing.transport-maritime', [
            'title' => 'Transport Maritime',
            'description' => 'Croisières et traversiers'
        ]);
    }

    /**
     * Afficher la page Hôtels
     */
    public function hotels()
    {
        return view('landing.hotels', [
            'title' => 'Hôtels',
            'description' => 'Réservez votre hébergement en hôtel'
        ]);
    }

    /**
     * Afficher la page Auberges
     */
    public function auberges()
    {
        return view('landing.auberges', [
            'title' => 'Auberges',
            'description' => 'Séjournez dans nos auberges chaleureuses'
        ]);
    }

    /**
     * Afficher la page Locations
     */
    public function locations()
    {
        return view('landing.locations', [
            'title' => 'Locations Saisonnières',
            'description' => 'Chalets, appartements et maisons de vacances'
        ]);
    }

    /**
     * Afficher la page Assurances
     */
    public function assurances()
    {
        return view('landing.assurances', [
            'title' => 'Assurances Voyage',
            'description' => 'Voyagez en toute sécurité avec nos assurances'
        ]);
    }

    /**
     * Afficher la page Guides
     */
    public function guides()
    {
        return view('landing.guides', [
            'title' => 'Guides Touristiques',
            'description' => 'Découvrez nos guides experts locaux'
        ]);
    }

    /**
     * Afficher la page Urgences
     */
    public function urgences()
    {
        return view('landing.urgences', [
            'title' => 'Assistance Urgence',
            'description' => 'Support et assistance 24/7'
        ]);
    }

    /**
     * Afficher la page Promotions
     */
    public function promotions()
    {
        return view('landing.promotions', [
            'title' => 'Promotions',
            'description' => 'Découvrez nos offres spéciales et promotions'
        ]);
    }

    /**
     * Afficher la page Explorer
     */
    public function explorer()
    {
        return view('landing.explorer', [
            'title' => 'Explorer',
            'description' => 'Explorez de nouvelles destinations'
        ]);
    }

    /**
     * Afficher la page Destinations
     */
    public function destinations()
    {
        return view('landing.destinations', [
            'title' => 'Destinations',
            'description' => 'Découvrez nos destinations populaires'
        ]);
    }

    /**
     * Afficher la page Certifications
     */
    public function certifications()
    {
        return view('landing.certifications', [
            'title' => 'Certifications',
            'description' => 'Nos certifications et garanties qualité'
        ]);
    }
}
