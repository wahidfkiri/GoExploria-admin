<?php

use Illuminate\Support\Facades\Route;



Route::middleware('web')->group(function () {

    Route::prefix('destination')->group(function () {
        Route::get('/countries/{code}', function (string $code) {
            return app(\App\Http\Controllers\DestinationPageController::class)->country($code);
        })->name('destination.countrie');

        Route::get('/countries/{countryCode}/provinces/{code}', function (string $countryCode, string $code) {
            return app(\App\Http\Controllers\DestinationPageController::class)->province($code);
        })->name('destination.province');

        Route::get('/{path}', [\App\Http\Controllers\DestinationPageController::class, 'hierarchy'])
            ->where('path', '.*')
            ->name('destination.hierarchy');

    });
});

