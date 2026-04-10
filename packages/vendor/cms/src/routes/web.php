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
        Route::get('/preview', [WebThemeController::class, 'preview'])->name('preview');
        
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

        // Route pour l'affichage du thème en iframe (sans layout parent)
        Route::get('/preview/iframe/{themeId?}/{slug?}', [App\Http\Controllers\ThemeIframeController::class, 'show'])
         ->name('cms.company.theme.iframe');
    });
    
    // Route pour les assets des thèmes (en dehors du préfixe company)
    Route::get('/themes/{etablissementId}/{themeSlug}/assets/{path}', [WebThemeController::class, 'asset'])
    ->where('path', '.*')
    ->name('cms.theme.asset');
    

// Routes API
Route::prefix('api/cms')->middleware(['web'])->group(function () {
    
    Route::prefix('company/{etablissementId}')->name('cms.api.')->group(function () {
        Route::get('/pages', [PublicPageController::class, 'getPagesApi'])->name('pages');
        Route::get('/pages/{slug}', [PublicPageController::class, 'getPageApi'])->name('page');
        Route::get('/search', [PublicPageController::class, 'searchApi'])->name('search');
        Route::post('/newsletter/subscribe', [PublicPageController::class, 'subscribeApi'])->name('newsletter.subscribe');
        Route::post('/contact', [PublicPageController::class, 'contactApi'])->name('contact');
    });

    Route::post('/subscribe', [PublicPageController::class, 'subscribeApi'])->name('cms.newsletter.subscribe');
});


// routes/web.php
Route::get('/theme-iframe/{etablissementId}/{slug?}', function($etablissementId, $slug = 'home') {
    $etablissement = App\Models\Etablissement::findOrFail($etablissementId);
    
    // Récupérer le thème actif
    $theme = $etablissement->themes()
        ->wherePivot('is_active', true)
        ->first();
    
    if (!$theme) {
        return "Aucun thème actif";
    }
    
    // Chemin du thème
    $themePath = storage_path("app/public/cms/themes/{$theme->slug}");
    
    // Récupérer la page
    $page = Vendor\Cms\Models\Page::where('etablissement_id', $etablissement->id)
        ->where('slug', $slug)
        ->where('status', 'published')
        ->first();
    
    // Enregistrer le namespace du thème
    Illuminate\Support\Facades\View::addNamespace('theme', $themePath);
    
    // Rendre le thème
    return view('theme::layout', [
        'page' => $page,
        'content' => $page->content ?? '',
        'etablissement' => $etablissement,
        'settings' => [],
        'menu' => []
    ]);
})->name('theme.iframe');



});



// Webhook
Route::post('/webhook/cms/{token}', [PublicPageController::class, 'webhook'])->name('cms.webhook');


