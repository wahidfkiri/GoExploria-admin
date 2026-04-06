<?php 

use Illuminate\Support\Facades\Route;
use Vendor\Cms\Controllers\Web\PublicPageController;


// Routes API
Route::prefix('cms')->middleware(['web'])->group(function () {
    
    Route::prefix('company/{etablissementId}')->name('cms.api.')->group(function () {
        Route::get('/pages', [PublicPageController::class, 'getPagesApi'])->name('pages');
        Route::get('/pages/{slug}', [PublicPageController::class, 'getPageApi'])->name('page');
        Route::get('/search', [PublicPageController::class, 'searchApi'])->name('search');
        Route::post('/newsletter/subscribe', [PublicPageController::class, 'subscribeApi'])->name('newsletter.subscribe');
        Route::post('/contact', [PublicPageController::class, 'contactApi'])->name('contact');
    });
});
