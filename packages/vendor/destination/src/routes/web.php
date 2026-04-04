<?php

use Illuminate\Support\Facades\Route;



Route::middleware('web')->group(function () {

    Route::prefix('destination')->group(function () {
        Route::get('/countries/{code}', [\Vendor\Destination\Controllers\DestinationController::class, 'countrie'])->name('destination.countrie');
        Route::get('/countries/{countryCode}/provinces/{code}', [\Vendor\Destination\Controllers\DestinationController::class, 'province'])->name('destination.province');

    });
});

