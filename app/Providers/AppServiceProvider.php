<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Telescope en local uniquement (paquet require-dev, absent en prod --no-dev).
        // On teste la présence du paquet AVANT de référencer notre provider (qui
        // hérite d'une classe Telescope) : sinon fatal « class not found » en prod.
        if ($this->app->environment('local')
            && class_exists(\Laravel\Telescope\TelescopeServiceProvider::class)) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(\App\Providers\TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        
        // Les pages de destination connaissent leur niveau (continent, pays,
        // ville…) par la variable « destinationContext » de leur vue. On le
        // range sur la requête pour que le middleware de la bannière
        // publicitaire de bas de page sache sur quelle famille de pages il se
        // trouve — il s'exécute après le rendu de la vue.
        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            $contexte = $view->getData()['destinationContext'] ?? null;
            $type = is_array($contexte) ? ($contexte['type'] ?? null) : (is_object($contexte) ? ($contexte->type ?? null) : null);

            if ($type && ($requete = request())) {
                $requete->attributes->set('gx_destination_context', (string) $type);
            }
        });

        // Service OpenAI
        $this->app->singleton(\App\Services\OpenAIService::class, function ($app) {
            return new \App\Services\OpenAIService();
        });
    }

    
}