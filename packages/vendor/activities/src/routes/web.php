<?php

use Illuminate\Support\Facades\Route;
use Vendor\Activities\Controllers\LandingPageController;

// Page d'accueil
Route::get('/activity', [LandingPageController::class, 'index'])->name('landing.home');

// Route principale pour les activités par slug
Route::prefix('/activity/{slug}')->name('landing.activity.')->group(function () {
    
    // Landing page principale de l'activité
    Route::get('/', [LandingPageController::class, 'showBySlug'])->name('show');
    
    // Routes pour les blogs
    Route::prefix('blog')->name('blog.')->group(function () {
        Route::get('/', [LandingPageController::class, 'blogs'])->name('index');
        Route::get('/{id}', [LandingPageController::class, 'showBlog'])->name('show');
    });
    
    // Routes pour les événements
    Route::prefix('evenements')->name('event.')->group(function () {
        Route::get('/', [LandingPageController::class, 'events'])->name('index');
        Route::get('/{id}', [LandingPageController::class, 'showEvent'])->name('show');
    });
    
    // Routes pour les témoignages
    Route::get('/temoignages', [LandingPageController::class, 'testimonials'])->name('testimonials');
});