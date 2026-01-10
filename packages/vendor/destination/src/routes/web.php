<?php

use Vendor\Destination\Controllers\DestinationController;
use Illuminate\Support\Facades\Route;


Auth::routes();

Route::middleware(['auth','web'])->group(function () {
// Routes pour les destinations
Route::prefix('destinations')->group(function () {
    Route::get('/', [DestinationController::class, 'index'])->name('destinations.index');
    Route::post('/', [DestinationController::class, 'store'])->name('destinations.store');
    Route::get('/{id}', [DestinationController::class, 'show'])->name('destinations.show');
    Route::put('/{id}', [DestinationController::class, 'update'])->name('destinations.update');
    Route::delete('/{id}', [DestinationController::class, 'destroy'])->name('destinations.destroy');
    
    // Routes supplémentaires
    Route::post('/{id}/restore', [DestinationController::class, 'restore'])->name('destinations.restore');
    Route::delete('/{id}/force-delete', [DestinationController::class, 'forceDelete'])->name('destinations.force-delete');
    Route::post('/{id}/toggle-status', [DestinationController::class, 'toggleStatus'])->name('destinations.toggle-status');
    Route::get('/statistics', [DestinationController::class, 'statistics'])->name('destinations.statistics');
    
});

});

Route::get('/api/destinations', [DestinationController::class, 'getActiveDestinations'])->name('destinations.active');
Route::get('/destination/{id}', [DestinationController::class, 'show'])->name('destination.show');