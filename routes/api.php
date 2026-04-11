<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    OpenAIController,
    TemplateController
    // ProjectController // Commenté temporairement
};
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\DestinationController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\MapPointController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::prefix('chat')->group(function () {
    Route::post('/send', [ChatController::class, 'chat']);
    Route::post('/with-context', [ChatController::class, 'chatWithContext']);
    Route::get('/history', [ChatController::class, 'getHistory']);
    Route::delete('/clear', [ChatController::class, 'clearHistory']);
});
Route::prefix('v1')->group(function () {
    
    // Public routes
    Route::get('/status', function () {
        return response()->json([
            'status' => 'online',
            'version' => '1.0.0',
            'timestamp' => now()
        ]);
    });
    
    // Authentication
    Route::post('/auth/login', [\App\Http\Controllers\AuthController::class, 'apiLogin']);
    Route::post('/auth/register', [\App\Http\Controllers\AuthController::class, 'apiRegister']);
    Route::post('/auth/logout', [\App\Http\Controllers\AuthController::class, 'apiLogout'])->middleware('auth:sanctum');
    
    // Protected routes
    Route::middleware(['auth:sanctum', 'throttle:60,1'])->group(function () {
        
        // User info
        Route::get('/user', function () {
            return response()->json(auth()->user());
        });
        
        // Templates API
        Route::apiResource('templates', TemplateController::class);
        Route::get('/templates/search/{query}', [TemplateController::class, 'search']);
        Route::post('/templates/{id}/clone', [TemplateController::class, 'clone']);
        
        // Projects API (commenté temporairement - ProjectController n'existe pas)
        // Route::apiResource('projects', ProjectController::class);
        // Route::post('/projects/{id}/publish', [ProjectController::class, 'publish']);
        
        // OpenAI API
        Route::prefix('ai')->group(function () {
            Route::post('/generate', [OpenAIController::class, 'generate']);
            Route::post('/optimize', [OpenAIController::class, 'optimize']);
            Route::post('/chat', [OpenAIController::class, 'chat']);
            Route::post('/code', [OpenAIController::class, 'code']);
            Route::post('/variations', [OpenAIController::class, 'variations']);
            Route::post('/improve', [OpenAIController::class, 'improve']);
            Route::get('/models', [OpenAIController::class, 'models']);
            Route::get('/usage/stats', [OpenAIController::class, 'usageStats']);
        });
        
        // Export API
        Route::post('/export/html', function () {
            return response()->json([
                'status' => 'success',
                'message' => 'HTML export endpoint'
            ]);
        });
        
        Route::post('/export/zip', function () {
            return response()->json([
                'status' => 'success',
                'message' => 'ZIP export endpoint'
            ]);
        });
    });
    
    // Destinations API (public, lecture seule)
    Route::prefix('destinations')->middleware('throttle:120,1')->group(function () {
        // Continents
        Route::get('/continents', [DestinationController::class, 'continents']);
        Route::get('/continents/{identifier}', [DestinationController::class, 'continent']);
        Route::get('/continents/{identifier}/countries', [DestinationController::class, 'countriesByContinent']);
        
        // Countries
        Route::get('/countries', [DestinationController::class, 'countries']);
        Route::get('/countries/{identifier}', [DestinationController::class, 'country']);
        Route::get('/countries/{identifier}/provinces', [DestinationController::class, 'provincesByCountry']);
        
        // Provinces
        Route::get('/provinces', [DestinationController::class, 'provinces']);
        Route::get('/provinces/{identifier}', [DestinationController::class, 'province']);
        Route::get('/provinces/{identifier}/regions', [DestinationController::class, 'regionsByProvince']);
        
        // Regions
        Route::get('/regions', [DestinationController::class, 'regions']);
        Route::get('/regions/{identifier}', [DestinationController::class, 'region']);
        Route::get('/regions/{identifier}/villes', [DestinationController::class, 'villesByRegion']);
        
        // Villes
        Route::get('/villes', [DestinationController::class, 'villes']);
        Route::get('/villes/{identifier}', [DestinationController::class, 'ville']);
        Route::get('/villes/{identifier}/secteurs', [DestinationController::class, 'secteursByVille']);
        
        // Secteurs
        Route::get('/secteurs', [DestinationController::class, 'secteurs']);
        Route::get('/secteurs/{identifier}', [DestinationController::class, 'secteur']);
        
        // Search & Hierarchy
        Route::get('/search', [DestinationController::class, 'search']);
        Route::get('/hierarchy/{type}/{identifier}', [DestinationController::class, 'hierarchy']);
    });
    
    // Categories API (public, lecture seule)
    Route::prefix('categories')->middleware('throttle:120,1')->group(function () {
        // Types de catégories
        Route::get('/types', [CategoryController::class, 'types']);
        Route::get('/types/{identifier}', [CategoryController::class, 'type']);
        
        // Catégories
        Route::get('/', [CategoryController::class, 'index']);
        Route::get('/search', [CategoryController::class, 'search']);
        Route::get('/popular', [CategoryController::class, 'popular']);
        Route::get('/grouped', [CategoryController::class, 'grouped']);
        Route::get('/stats', [CategoryController::class, 'stats']);
        Route::get('/by-type/{typeSlug}', [CategoryController::class, 'byTypeSlug']);
        Route::get('/{identifier}', [CategoryController::class, 'show']);
    });
    
    // Menus API (public, lecture seule)
    Route::prefix('menus')->middleware('throttle:120,1')->group(function () {
        // Menus racines et arborescence
        Route::get('/roots', [MenuController::class, 'roots']);
        Route::get('/tree', [MenuController::class, 'tree']);
        Route::get('/html', [MenuController::class, 'html']);
        Route::get('/with-pages', [MenuController::class, 'withPages']);
        Route::get('/stats', [MenuController::class, 'stats']);
        
        // Recherche et filtres
        Route::get('/search', [MenuController::class, 'search']);
        Route::get('/by-type/{type}', [MenuController::class, 'byType']);
        Route::get('/by-category/{categoryId}', [MenuController::class, 'byCategory']);
        Route::get('/by-activity/{activityId}', [MenuController::class, 'byActivity']);
        
        // Menu spécifique
        Route::get('/{identifier}', [MenuController::class, 'show']);
        Route::get('/{identifier}/breadcrumb', [MenuController::class, 'breadcrumb']);
        Route::get('/{parentId}/children', [MenuController::class, 'children']);
    });
    
    // Map Points API (public, lecture seule)
    Route::prefix('map-points')->middleware('throttle:120,1')->group(function () {
        // Liste et filtres
        Route::get('/', [MapPointController::class, 'index']);
        Route::get('/bounds', [MapPointController::class, 'bounds']);
        Route::get('/featured', [MapPointController::class, 'featured']);
        Route::get('/categories', [MapPointController::class, 'categories']);
        Route::get('/villes', [MapPointController::class, 'villes']);
        Route::get('/stats', [MapPointController::class, 'stats']);
        Route::get('/nearby', [MapPointController::class, 'nearby']);
        
        // Recherche
        Route::get('/search', [MapPointController::class, 'search']);
        Route::get('/category/{category}', [MapPointController::class, 'byCategory']);
        Route::get('/ville/{ville}', [MapPointController::class, 'byVille']);
        
        // Point spécifique et ses relations
        Route::get('/{id}', [MapPointController::class, 'show']);
        Route::get('/{id}/images', [MapPointController::class, 'images']);
        Route::get('/{id}/videos', [MapPointController::class, 'videos']);
        Route::get('/{id}/details', [MapPointController::class, 'details']);
        Route::post('/{id}/view', [MapPointController::class, 'incrementView']);
    });
    
    // Demo routes (public but limited)
    Route::prefix('demo')->middleware('throttle:20,1440')->group(function () {
        Route::post('/ai/generate', [OpenAIController::class, 'demoGenerate']);
        Route::get('/templates', [TemplateController::class, 'demoTemplates']);
        Route::get('/templates/{id}', [TemplateController::class, 'demoShow']);
    });
});