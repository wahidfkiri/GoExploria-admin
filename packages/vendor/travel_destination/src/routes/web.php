<?php

use Illuminate\Support\Facades\Route;
use Vendor\TravelDestination\Controllers\TravelDestinationController;

Route::prefix('travel-destination')->group(function () {
    Route::get('/{type}/{slug}/map-points', [TravelDestinationController::class, 'mapPoints'])
        ->name('travel-destination.map-points')
        ->whereIn('type', ['continent', 'continents', 'country', 'countries', 'province', 'provinces', 'region', 'regions', 'city', 'cities', 'secteur', 'secteurs', 'arrondissement', 'arrondissements', 'quartier', 'quartiers']);

    // Enfants directs d'une destination : alimente la cascade de filtres posée
    // au-dessus de la carte, un niveau à la fois.
    // ⚠ Doit rester AVANT la route générique /{type}/{slug}/{slug2?}, sinon
    //   « children » serait lu comme un second segment de slug.
    Route::get('/{type}/{slug}/children', [TravelDestinationController::class, 'children'])
        ->name('travel-destination.children')
        ->whereIn('type', ['continent', 'continents', 'country', 'countries', 'province', 'provinces', 'region', 'regions', 'city', 'cities', 'secteur', 'secteurs', 'arrondissement', 'arrondissements', 'quartier', 'quartiers']);

    Route::get('/{type}/{slug}/{slug2?}', [TravelDestinationController::class, 'show'])
        ->name('travel-destination.show')
        ->whereIn('type', ['continent', 'continents', 'country', 'countries', 'province', 'provinces', 'region', 'regions', 'city', 'cities', 'secteur', 'secteurs', 'arrondissement', 'arrondissements', 'quartier', 'quartiers']);
});
