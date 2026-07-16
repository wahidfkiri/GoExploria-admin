<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    EditorController,
    TemplateController,
    OpenAIController,
    AuthController,
    GeminiController,
    HomeController,
    LandingPageController,
    DestinationPageController,
    DevisController,
    SitemapController
};
use Vendor\HomeV2\Http\Controllers\HomeV2Controller;

use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\Auth\AjaxAuthController;
use App\Http\Controllers\TemplateScraperController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');
Route::post('/chat/clear-history', [ChatController::class, 'clearHistory'])->name('chat.clear-history');

// Sitemaps dynamiques (Google Search Console)
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap.index');
Route::prefix('sitemaps')->name('sitemaps.')->group(function () {
    Route::get('/core.xml', [SitemapController::class, 'core'])->name('core');
    Route::get('/destinations.xml', [SitemapController::class, 'destinations'])->name('destinations');
    Route::get('/companies.xml', [SitemapController::class, 'companies'])->name('companies');
});
Route::get('/robots.txt', function () {
    $content = "User-agent: *\n";
    $content .= "Allow: /\n";
    $content .= "Sitemap: " . url('/sitemap.xml') . "\n";

    return response($content, 200, [
        'Content-Type' => 'text/plain; charset=UTF-8',
        'Cache-Control' => 'public, max-age=3600',
    ]);
})->name('robots');

Route::get('/cdn-storage/{path}', [CDNController::class, 'getFile'])
    ->where('path', '.*')
    ->name('cdn.public-file');

// Page d'accueil = page Welcome (remplace l'ancienne home-v2)
Route::get('/', [\Vendor\Welcome\Http\Controllers\WelcomeController::class, 'index'])->name('home-v2');

Route::get('/locale/{locale}', function (string $locale) {
    $supported = ['fr', 'en', 'es', 'de', 'it'];

    if (! in_array($locale, $supported, true)) {
        $locale = 'fr';
    }

    session(['locale' => $locale]);
    app()->setLocale($locale);

    $fallback = url()->previous() ?: route('home-v2');
    $redirect = request()->query('redirect', $fallback);

    if (! is_string($redirect)) {
        $redirect = $fallback;
    }

    $appHost = parse_url(url('/'), PHP_URL_HOST);
    $redirectHost = parse_url($redirect, PHP_URL_HOST);

    if ($redirectHost !== null && $redirectHost !== $appHost) {
        $redirect = $fallback;
    }

    return redirect()->to($redirect);
})->name('locale.switch');

Route::get('welcome-2', function () {
    return view('welcome');
});
Route::get('/map', function () {
    return view('home-v2.map');
})->name('home-v2.map');

// Nouvelle page d'accueil V2
Route::get('/home-v2', [HomeV2Controller::class, 'index'])->name('home-v2');

// Routes pour les pages de destinations
Route::prefix('destinations')->name('destinations.')->group(function () {
    Route::get('/', [DestinationPageController::class, 'index'])->name('index');
    Route::get('/continent/{slug}', [DestinationPageController::class, 'continent'])->name('continent');
    Route::get('/pays/{slug}', [DestinationPageController::class, 'country'])->name('country');
    Route::get('/province/{slug}', [DestinationPageController::class, 'province'])->name('province');
    Route::get('/region/{slug}', [DestinationPageController::class, 'region'])->name('region');
    Route::get('/ville/{slug}', [DestinationPageController::class, 'ville'])->name('ville');
    Route::get('/secteur/{slug}', [DestinationPageController::class, 'secteur'])->name('secteur');
    Route::get('/{path}', [DestinationPageController::class, 'hierarchy'])
        ->where('path', '.*')
        ->name('hierarchy');
});

// Landing Pages Routes
Route::prefix('landing')->name('landing.')->group(function () {
    Route::get('/experiences-quebec', [LandingPageController::class, 'experiencesQuebec'])->name('experiences-quebec');
    Route::get('/experiences-canada', [LandingPageController::class, 'experiencesCanada'])->name('experiences-canada');
    Route::get('/experiences-regional', [LandingPageController::class, 'experiencesRegional'])->name('experiences-regional');
    Route::get('/transport-aerien', [LandingPageController::class, 'transportAerien'])->name('transport-aerien');
    Route::get('/transport-terrestre', [LandingPageController::class, 'transportTerrestre'])->name('transport-terrestre');
    Route::get('/transport-maritime', [LandingPageController::class, 'transportMaritime'])->name('transport-maritime');
    Route::get('/hotels', [LandingPageController::class, 'hotels'])->name('hotels');
    Route::get('/auberges', [LandingPageController::class, 'auberges'])->name('auberges');
    Route::get('/locations', [LandingPageController::class, 'locations'])->name('locations');
    Route::get('/assurances', [LandingPageController::class, 'assurances'])->name('assurances');
    Route::get('/guides', [LandingPageController::class, 'guides'])->name('guides');
    Route::get('/urgences', [LandingPageController::class, 'urgences'])->name('urgences');
    Route::get('/promotions', [LandingPageController::class, 'promotions'])->name('promotions');
    Route::get('/explorer', [LandingPageController::class, 'explorer'])->name('explorer');
    Route::get('/destinations', [LandingPageController::class, 'destinations'])->name('destinations');
    Route::get('/certifications', [LandingPageController::class, 'certifications'])->name('certifications');
});

// Page de login
Route::get('/login', function () {
    return view('auth.login');
})->name('login');


// Route pour le dashboard (à protéger)
Route::get('/home', function () {
    return view('home');
})->name('home')->middleware('auth');

// Authentification Ajax
Route::post('/ajax-login', [AjaxAuthController::class, 'login'])->name('ajax.login');
Route::post('/ajax/register', [AuthController::class, 'ajaxRegister'])->name('ajax.register');
Route::get('/ajax-register', [AjaxAuthController::class, 'showRegisterForm'])->name('register');
// Routes d'authentification sociale
Route::get('/auth/google', [SocialAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);
Route::get('/auth/facebook', [SocialAuthController::class, 'redirectToFacebook'])->name('auth.facebook');
Route::get('/auth/facebook/callback', [SocialAuthController::class, 'handleFacebookCallback']);

// Logout
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');


// Éditeur (protégé)
Route::middleware(['auth','web','user.active'])->group(function () {


// Route pour le dashboard (à protéger)
Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    
    // Profil utilisateur
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        
        // Mise à jour des informations
        Route::put('/info', [ProfileController::class, 'updateInfo'])->name('update.info');
        Route::post('/avatar', [ProfileController::class, 'updateAvatar'])->name('update.avatar');
        
        // Sécurité
        Route::put('/password', [ProfileController::class, 'changePassword'])->name('change.password');
        Route::post('/2fa/toggle', [ProfileController::class, 'toggleTwoFactor'])->name('2fa.toggle');
        Route::delete('/sessions/{session}', [ProfileController::class, 'revokeSession'])->name('sessions.revoke');
        
        // Préférences
        Route::put('/preferences', [ProfileController::class, 'updatePreferences'])->name('update.preferences');
        
        // Notifications
        Route::put('/notifications', [ProfileController::class, 'updateNotifications'])->name('update.notifications');
        
        // Activités
        Route::get('/activities', [ProfileController::class, 'getActivities'])->name('activities');
    });


// Template scraping routes
Route::prefix('/scrape/templates')->group(function () {
    Route::get('/', [TemplateScraperController::class, 'index'])->name('templates.index');
    Route::get('/create', [TemplateScraperController::class, 'create'])->name('templates.create');
    Route::post('/', [TemplateScraperController::class, 'store'])->name('scrape.templates.store');
    Route::get('/{template}', [TemplateScraperController::class, 'show'])->name('templates.show');
    Route::get('/{template}/edit', [TemplateScraperController::class, 'edit'])->name('templates.edit');
    Route::put('/{template}', [TemplateScraperController::class, 'update'])->name('templates.update');
    Route::delete('/{template}', [TemplateScraperController::class, 'destroy'])->name('templates.destroy');
    Route::post('/scrape-now', [TemplateScraperController::class, 'scrapeNow'])->name('templates.scrape-now');
    Route::get('/{template}/preview', [TemplateScraperController::class, 'preview'])->name('templates.preview');
    Route::get('/{template}/raw-html', [TemplateScraperController::class, 'rawHtml'])->name('templates.raw-html');
    Route::get('/{template}/raw-css', [TemplateScraperController::class, 'rawCss'])->name('templates.raw-css');
});

// API Routes
Route::prefix('api')->group(function () {
    Route::get('/templates', [TemplateScraperController::class, 'apiIndex']);
    Route::post('/templates/scrape', [TemplateScraperController::class, 'apiScrape']);
    Route::get('/templates/{template}', [TemplateScraperController::class, 'apiShow']);
});

// Batch scraping route
Route::post('/batch-scrape', [TemplateScraperController::class, 'batchScrape'])->name('batch.scrape');



// routes/web.php ou routes/api.php

// routes/web.php
Route::get('/gemini/generate', [GeminiController::class, 'generate'])->name('gemini.generate');
Route::get('/gemini/test', [GeminiController::class, 'test'])->name('gemini.test');
});

// API Routes (protégées par Sanctum)
Route::prefix('api')->group(function () {
    
    // Routes publiques
    Route::post('/auth/login', [AuthController::class, 'apiLogin']);
    Route::post('/auth/register', [AuthController::class, 'apiRegister']);
    Route::get('/status', function () {
        return response()->json([
            'status' => 'online',
            'version' => '1.0.0',
            'timestamp' => now()
        ]);
    });
    
    // Routes API Destinations (publiques)
    Route::prefix('v1/destinations')->group(function () {
        Route::get('/continents', [App\Http\Controllers\Api\DestinationController::class, 'continents']);
        Route::get('/continents/{identifier}', [App\Http\Controllers\Api\DestinationController::class, 'continent']);
        Route::get('/continents/{identifier}/countries', [App\Http\Controllers\Api\DestinationController::class, 'countriesByContinent']);
        Route::get('/countries', [App\Http\Controllers\Api\DestinationController::class, 'countries']);
        Route::get('/countries/{identifier}', [App\Http\Controllers\Api\DestinationController::class, 'country']);
        Route::get('/countries/{identifier}/provinces', [App\Http\Controllers\Api\DestinationController::class, 'provincesByCountry']);
        Route::get('/provinces', [App\Http\Controllers\Api\DestinationController::class, 'provinces']);
        Route::get('/provinces/{identifier}', [App\Http\Controllers\Api\DestinationController::class, 'province']);
        Route::get('/provinces/{identifier}/regions', [App\Http\Controllers\Api\DestinationController::class, 'regionsByProvince']);
        Route::get('/regions', [App\Http\Controllers\Api\DestinationController::class, 'regions']);
        Route::get('/regions/{identifier}', [App\Http\Controllers\Api\DestinationController::class, 'region']);
        Route::get('/regions/{identifier}/villes', [App\Http\Controllers\Api\DestinationController::class, 'villesByRegion']);
        Route::get('/villes', [App\Http\Controllers\Api\DestinationController::class, 'villes']);
        Route::get('/villes/{identifier}', [App\Http\Controllers\Api\DestinationController::class, 'ville']);
        Route::get('/villes/{identifier}/secteurs', [App\Http\Controllers\Api\DestinationController::class, 'secteursByVille']);
        Route::get('/secteurs', [App\Http\Controllers\Api\DestinationController::class, 'secteurs']);
        Route::get('/secteurs/{identifier}', [App\Http\Controllers\Api\DestinationController::class, 'secteur']);
        Route::get('/search', [App\Http\Controllers\Api\DestinationController::class, 'search']);
        Route::get('/hierarchy/{type}/{identifier}', [App\Http\Controllers\Api\DestinationController::class, 'hierarchy']);
    });
    
    // Routes API Map Points (publiques)
    Route::prefix('v1/map-points')->group(function () {
        Route::get('/', [App\Http\Controllers\Api\MapPointController::class, 'index']);
        Route::get('/{id}', [App\Http\Controllers\Api\MapPointController::class, 'show']);
        Route::get('/search', [App\Http\Controllers\Api\MapPointController::class, 'search']);
        Route::get('/categories', [App\Http\Controllers\Api\MapPointController::class, 'categories']);
        Route::get('/villes', [App\Http\Controllers\Api\MapPointController::class, 'villes']);
    });
    
    // Routes démo (limitées)
    Route::prefix('demo')->group(function () {
        Route::post('/ai/generate', [OpenAIController::class, 'demoGenerate'])
            ->middleware('throttle:5,1440'); // 5 requêtes par jour
            
        Route::get('/templates', [TemplateController::class, 'demoTemplates']);
    });
    
    // Routes authentifiées
    Route::middleware('auth:sanctum')->group(function () {
        
        // User info
        Route::get('/user', function () {
            return response()->json([
                'user' => auth()->user(),
                'token' => auth()->user()->currentAccessToken()
            ]);
        });
        
        Route::post('/auth/logout', [AuthController::class, 'apiLogout']);
        
        // Templates CRUD
        Route::apiResource('templates', TemplateController::class);
        Route::get('/templates/{id}/preview', [TemplateController::class, 'preview'])->name('templates.preview');
        Route::get('/templates/search/{query}', [TemplateController::class, 'search']);
        Route::post('/templates/{id}/clone', [TemplateController::class, 'clone']);
        
        // OpenAI Routes
        Route::prefix('ai')->group(function () {
            Route::post('/generate', [OpenAIController::class, 'generate'])
                ->middleware('throttle:30,1'); // 30 requêtes par minute
                
            Route::post('/optimize', [OpenAIController::class, 'optimize']);
            Route::post('/chat', [OpenAIController::class, 'chat'])
                ->middleware('throttle:60,1');
                
            Route::post('/code', [OpenAIController::class, 'code']);
            Route::post('/variations', [OpenAIController::class, 'variations']);
            Route::post('/improve', [OpenAIController::class, 'improve']);
            Route::get('/models', [OpenAIController::class, 'models']);
            Route::get('/usage', [OpenAIController::class, 'usage']);
            Route::get('/usage/stats', [OpenAIController::class, 'usageStats']);
            Route::get('/status', [OpenAIController::class, 'status']);
        });
    });

 
});

// Routes de santé
Route::get('/health', function () {
    return response()->json([
        'status' => 'healthy',
        'timestamp' => now(),
        'services' => [
            'laravel' => app()->version(),
            'php' => PHP_VERSION,
            'database' => DB::connection()->getPdo() ? 'connected' : 'disconnected'
        ]
    ]);
});





Route::prefix('pages')->name('pages.')->group(function () {
    Route::get('/video-player', function() {
        return view('home-v2.pages.video-player');
    })->name('video-player');

    Route::get('/accord-mets-vins', function() {
        return view('home-v2.pages.accord-mets-vins');
    })->name('accord-mets-vins');

    Route::get('/chalets-a-louer/grande-serenite', function() {
        return view('home-v2.pages.chalet-rental-detail-grande-serenite-v2');
    })->name('chalet-rental-detail');

    Route::get('/chalets-a-louer/lac-azur-signature', function() {
        return view('home-v2.pages.chalet-rental-lac-azur');
    })->name('chalet-rental-lac-azur');

    Route::get('/maisons-chalets-a-vendre/eclipse-forestier', function() {
        return view('home-v2.pages.maison-forestiere-eclipse');
    })->name('maison-forestiere-eclipse');

    Route::get('/projets-touristiques/halte-boreale', function() {
        return view('home-v2.pages.projet-touristique-boreal');
    })->name('projet-touristique-boreal');
});


// Pages Catégories & Activités
Route::get('/categories',                  [\Vendor\HomeV2\Http\Controllers\HomeV2Controller::class, 'categoriesIndex'])->name('categories.index');
Route::get('/categories/{slug}',           [\Vendor\HomeV2\Http\Controllers\HomeV2Controller::class, 'showCategory'])->name('category.show');
Route::get('/activites/{slug}',            function () {
    return redirect('/activity/' . request()->route('slug'));
})->name('activity.show');

// Landing publique des Services (gérés dans l'admin /services)
Route::get('/nos-services/{slug}', [\Vendor\Welcome\Http\Controllers\ServicesController::class, 'show'])->name('service.landing');

// Pages principales du Header
Route::get('/contact',      fn() => view('home-v2.pages.contact'))->name('contact');
Route::get('/valeurs',      fn() => view('home-v2.pages.valeurs'))->name('valeurs');
Route::get('/inscription',  fn() => view('home-v2.pages.inscription'))->name('inscription');
Route::get('/mon-compte',   fn() => redirect()->away('https://app.goexploriabusiness.com/register'))->name('mon-compte');
Route::get('/devis',        [DevisController::class, 'show'])->name('devis');
Route::post('/confirm/devis',       [DevisController::class, 'submit'])->name('devis.submit');
Route::post('/devis/paypal/capture-order', [DevisController::class, 'paypalCaptureOrder'])->name('devis.paypal.capture');
Route::get('/devis/paypal/success', [DevisController::class, 'paypalSuccess'])->name('devis.paypal.success');
Route::get('/devis/paypal/cancel',  [DevisController::class, 'paypalCancel'])->name('devis.paypal.cancel');
Route::get('/devis/service/{billingRequestService}/{slug?}', [DevisController::class, 'serviceDetail'])->name('devis.service.detail');
Route::get('/favoris',      fn() => view('home-v2.pages.favoris'))->name('favoris');
Route::get('/panier',       fn() => view('home-v2.pages.panier'))->name('panier');
Route::get('/politique-confidentialite', fn() => view('home-v2.pages.privacy-policy'))->name('privacy.policy');
Route::get('/termes-et-conditions', fn() => view('home-v2.pages.terms-conditions'))->name('terms.conditions');
Route::get('/espace-photos', fn() => view('home-v2.pages.espace_media.espace-photos'))->name('espace-photos');
Route::get('/avis-clients', fn() => view('home-v2.pages.espace_media.avis-clients'))->name('avis-clients');
Route::get('/business-tourisme', fn() => view('home-v2.pages.espace_media.business-tourisme'))->name('business-tourism');
Route::get('/page-destinations', fn() => view('home-v2.pages.espace_media.destinations'))->name('page-destinations');
Route::get('/page-blog', fn() => view('home-v2.pages.espace_media.blog'))->name('page-blog');
Route::get('/page-chat', fn() => view('home-v2.pages.espace_media.page-chat'))->name('page-chat');
Route::get('/page-mail-marketing', fn() => view('home-v2.pages.espace_media.page-mail-marketing'))->name('page-mail-marketing');
Route::get('/page-social-media', fn() => view('home-v2.pages.espace_media.page-social-media'))->name('page-social-media');
Route::get('/page-galerie', fn() => view('home-v2.pages.espace_media.page-galerie'))->name('page-galerie');
Route::get('/page-multilingue', fn() => view('home-v2.pages.espace_media.page-multilingue'))->name('page-multilingue');
Route::get('/page-tiktok', fn() => view('home-v2.pages.espace_media.page-tiktok'))->name('page-tiktok');
Route::get('/page-videos', fn() => view('home-v2.pages.espace_media.page-videos'))->name('page-videos');
Route::get('/page-medias', fn() => view('home-v2.pages.espace_media.page-media-players'))->name('page-medias');

// Routes pour les sections de l'Espace Next Level 
Route::get('/espace-next-level/agency', fn() => view('home-v2.pages.espace_next_level.page_agency'))->name('espace-next-level.agency');
Route::get('/espace-next-level/plans', fn() => view('home-v2.pages.espace_next_level.page_plans'))->name('espace-next-level.plans');
Route::get('/espace-next-level/editeur', fn() => view('home-v2.pages.espace_next_level.page_editeur'))->name('espace-next-level.editeur');
Route::get('/espace-next-level/api', fn() => view('home-v2.pages.espace_next_level.page_espace_api'))->name('espace-next-level.api');
Route::get('/espace-next-level/formulaire', fn() => view('home-v2.pages.espace_next_level.page_formulaire'))->name('espace-next-level.formulaire');
Route::get('/espace-next-level/seo', fn() => view('home-v2.pages.espace_next_level.page_espace_seo'))->name('espace-next-level.seo');
Route::get('/espace-next-level/tele-positionnement', fn() => view('home-v2.pages.espace_next_level.page_espace_tele_positionnement'))->name('espace-next-level.tele-positionnement');


// Route evenement vidette
Route::get('/evenement-vedette', fn() => view('home-v2.pages.espace_evenement_vidette.page_evenement_vidette'))->name('evenement-vedette');

// Route forfaits & voyages
Route::get('/forfaits-voyages', fn() => view('home-v2.pages.espace_forfaits.page_forfaits_voyages'))->name('forfaits-voyages');

// Chemins publics de destinations: amerique-du-nord/canada/quebec/...
// La route est volontairement placée en dernier et rend une page seulement si le chemin correspond à une destination active.
Route::get('/{destinationPath}', [DestinationPageController::class, 'hierarchyFromRoot'])
    ->where('destinationPath', '^(?!.*\.(?:css|js|png|jpg|jpeg|gif|svg|ico|webp|map|json|xml)$)(?!(?:api|admin|cms|company|destination|destinations|landing|pages|categories|activites|contact|devis|valeurs|inscription|mon-compte|favoris|panier|sitemaps|sitemap\.xml|robots\.txt|health)(?:/|$)).+')
    ->name('destinations.hierarchy-root');
