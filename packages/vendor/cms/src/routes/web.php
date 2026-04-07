<?php

use Illuminate\Support\Facades\Route;
use Vendor\Cms\Controllers\Web\PublicPageController;
use Vendor\Cms\Controllers\Web\WebThemeController;

/*
|--------------------------------------------------------------------------
| Routes publiques (frontend) avec préfixe /company/{etablissementId}
|--------------------------------------------------------------------------
*/
Route::middleware(['web'])->group(function () {
    // Redirection de la racine vers le premier établissement
    // Route::get('/', function () {
    //     $etablissement = \App\Models\Etablissement::first();
    //     if ($etablissement) {
    //         return redirect()->route('cms.company.home', ['etablissementId' => $etablissement->id]);
    //     }
    //     abort(404, 'Aucun établissement trouvé');
    // });
    
    // ============================================
    // Routes avec préfixe /company/{etablissementId}
    // ============================================
    Route::prefix('/company/{etablissementId}')->name('cms.company.')->group(function () {
        
        // Page d'accueil - ACCEPTE LE PARAMETRE GET preview_theme
        Route::get('/', [WebThemeController::class, 'home'])->name('home');
        
        // Pages dynamiques - ACCEPTE LE PARAMETRE GET preview_theme
        Route::get('/page/{slug}', [WebThemeController::class, 'showPage'])->name('page');
        
        // Sitemap et robots
        Route::get('/sitemap.xml', [WebThemeController::class, 'sitemap'])->name('sitemap');
        Route::get('/robots.txt', [WebThemeController::class, 'robots'])->name('robots');
        
        // Routes de prévisualisation
        Route::get('/preview/theme/{id}', [WebThemeController::class, 'publicPreview'])->name('preview.theme');
        Route::get('/preview/theme/{themeId}/page/{pageId}', [WebThemeController::class, 'previewPage'])->name('preview.page');
        Route::get('/preview/theme/{id}/quick', [WebThemeController::class, 'quickPreview'])->name('preview.quick');
        
        // Routes des thèmes
        Route::get('/themes', [WebThemeController::class, 'index'])->name('themes.index');
        Route::get('/themes/{id}', [WebThemeController::class, 'show'])->name('themes.show');
        Route::get('/themes/{id}/download', [WebThemeController::class, 'download'])->name('themes.download');
        
        // API
        Route::get('/api/pages', [PublicPageController::class, 'getPages'])->name('api.pages');
        Route::get('/api/pages/{slug}', [PublicPageController::class, 'getPageBySlug'])->name('api.page');
        
        // Recherche
        Route::get('/search', [PublicPageController::class, 'search'])->name('search');
        Route::get('/search/ajax', [PublicPageController::class, 'searchAjax'])->name('search.ajax');
        
        // Contact
        Route::get('/contact', [PublicPageController::class, 'contact'])->name('contact');
        Route::post('/contact/send', [PublicPageController::class, 'sendContact'])->name('contact.send');
        
        // Newsletter
        Route::post('/newsletter/subscribe', [PublicPageController::class, 'subscribeNewsletter'])->name('newsletter.subscribe');
        Route::get('/newsletter/unsubscribe/{token}', [PublicPageController::class, 'unsubscribeNewsletter'])->name('newsletter.unsubscribe');
        
        // Mot de passe
        Route::post('/page/check-password', [PublicPageController::class, 'checkPassword'])->name('page.check-password');
        
        // Nettoyer la prévisualisation
        Route::get('/clear-preview', [WebThemeController::class, 'clearPreview'])->name('clear-preview');
    });
    
    // Route pour les assets des thèmes (en dehors du préfixe company)
    Route::get('/themes/{etablissementId}/{themeSlug}/assets/{path}', [WebThemeController::class, 'asset'])
    ->where('path', '.*')
    ->name('cms.theme.asset');
    

});



// Webhook
Route::post('/webhook/cms/{token}', [PublicPageController::class, 'webhook'])->name('cms.webhook');
