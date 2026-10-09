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

    /* Feuille de style du contenu CMS de l'accueil, sortie du corps de la
       page : 460 Ko qui partaient dans CHAQUE réponse HTML, désormais servis
       une fois et gardés en cache par le navigateur. L'adresse porte
       l'empreinte du contenu (?v=), donc une version ne change jamais. */
    Route::get('/welcome/accueil.css', [WelcomeController::class, 'cssAccueil'])
        ->name('welcome.accueil-css');

    /* Contenu du méga-menu « Activités » : 760 Ko qui partaient dans la page
       d'accueil pour un menu rarement ouvert. Chargé au premier besoin. */
    Route::get('/welcome/menu/activites', [WelcomeController::class, 'menuActivites'])
        ->name('welcome.menu.activites');
});
