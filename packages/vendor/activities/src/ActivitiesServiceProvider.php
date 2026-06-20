<?php

namespace Vendor\Activities;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class ActivitiesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {

        // Register view namespace
        $this->loadViewsFrom(__DIR__ . '/Views', 'activities');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        
       
        // Load routes
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');

        // Load views
        $this->loadViewsFrom(__DIR__.'/Views', 'activities');

        // Blade::component('drive-google-drive-main-app', MainApp::class);

        // Publish assets if needed
        $this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/activities'),
        ], 'activities-assets');
    }

    /**
     * Register routes.
     */

}