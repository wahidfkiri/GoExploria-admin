<?php

use Illuminate\Support\Facades\Route;
use Vendor\Welcome\Http\Controllers\WelcomeController;

/*
|--------------------------------------------------------------------------
| Routes du package Welcome
|--------------------------------------------------------------------------
| Nouvelle page d'accueil premium, accessible sur /welcome.
| N'interfère pas avec la route « home-v2 » existante.
*/
Route::middleware('web')->group(function () {
    Route::get('/welcome', [WelcomeController::class, 'index'])->name('welcome');
});
