<?php

use Illuminate\Support\Facades\Route;
use Vendor\TravelDestination\Controllers\TravelDestinationController;

Route::prefix('travel-destination')->group(function () {
    Route::get('/{type}/{slug}', [TravelDestinationController::class, 'show'])
        ->name('travel-destination.show')
        ->whereIn('type', ['continent', 'continents', 'country', 'countries', 'province', 'provinces', 'region', 'regions', 'city', 'cities', 'secteur', 'secteurs']);

    Route::get('/{type}/{slug}/map-points', [TravelDestinationController::class, 'mapPoints'])
        ->name('travel-destination.map-points')
        ->whereIn('type', ['continent', 'continents', 'country', 'countries', 'province', 'provinces', 'region', 'regions', 'city', 'cities', 'secteur', 'secteurs']);
});
