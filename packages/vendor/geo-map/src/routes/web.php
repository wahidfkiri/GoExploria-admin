<?php

use Illuminate\Support\Facades\Route;
use Vendor\GeoMap\Controllers\MapPointController;


// Routes pour la carte interactive
Route::prefix('/geo-map')->group(function () {
    // Points sur la carte
    Route::get('/', [MapPointController::class, 'preview'])->name('geo-map.index');
    Route::get('/points', [MapPointController::class, 'index']);
    Route::get('/points/{id}', [MapPointController::class, 'show']);
    
    // Filtres spécifiques
    Route::get('/points/category/{category}', [MapPointController::class, 'getByCategory']);
    Route::get('/points/nearby', [MapPointController::class, 'getNearby']);
    Route::get('/featured', [MapPointController::class, 'getFeatured']);
    Route::get('/stats', [MapPointController::class, 'getStats']);
    Route::get('/provinces', [MapPointController::class, 'getProvincesStats']);
});

Route::get('/test-map', function() {
    return view('geo-map::index');
})->name('test.map');