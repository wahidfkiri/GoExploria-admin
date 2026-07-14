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
    // La page Welcome est désormais la page d'accueil « / » :
    // /welcome redirige vers / pour éviter le contenu dupliqué.
    Route::get('/welcome', fn () => redirect('/', 301))->name('welcome');
});
