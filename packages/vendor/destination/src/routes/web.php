<?php

use Illuminate\Support\Facades\Route;



Route::middleware('web')->group(function () {

    Route::prefix('destination')->group(function () {
        Route::get('/continents/{code}', [\Vendor\Destination\Controllers\DestinationController::class, 'countrie'])->name('destination.countrie');
        Route::get('/provinces/{code}', [\Vendor\Destination\Controllers\DestinationController::class, 'province'])->name('destination.province');

    });
});

