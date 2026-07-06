<?php

namespace Vendor\TravelDestination;

use Illuminate\Support\ServiceProvider;

class TravelDestinationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/Views', 'travel-destination');

        $this->publishes([
            __DIR__ . '/../resources/assets' => public_path('vendor/travel-destination'),
        ], 'travel-destination-assets');
    }

    public function register()
    {
        //
    }
}
