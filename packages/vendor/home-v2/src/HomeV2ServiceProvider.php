<?php

namespace Vendor\HomeV2;

use Illuminate\Support\ServiceProvider;

class HomeV2ServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // ── Résolution DOT-NOTATION (compatibilité totale avec le code existant) ──────
        // @include('home-v2.components.EventsVedette') → trouve le fichier dans le package.
        // La résolution cherche home-v2/components/EventsVedette.blade.php dans chaque
        // chemin enregistré. En ajoutant le chemin du package EN FIN DE LISTE, le dossier
        // resources/views/ de l'application reste prioritaire (permet les overrides locaux).
        $this->callAfterResolving('view', function ($view) {
            $view->addLocation(__DIR__ . '/resources/views');
        });

        // ── Résolution NAMESPACE (pour une future migration progressive) ───────────────
        // @include('home-v2::components.EventsVedette')
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'home-v2');

        // ── Publication des assets vers public/ ───────────────────────────────────────
        // php artisan vendor:publish --tag=home-v2-assets --force
        $this->publishes([
            __DIR__ . '/resources/css' => public_path('css/home-v2'),
            __DIR__ . '/resources/js'  => public_path('js/home-v2'),
        ], 'home-v2-assets');
    }
}
