<?php

namespace Vendor\Welcome;

use Illuminate\Support\ServiceProvider;

/**
 * Service provider du package Welcome.
 *
 * /welcome = clone INDÉPENDANT de la page d'accueil (design identique à « / »),
 * optimisé pour la vitesse de chargement et le responsive. Aucune dépendance au
 * code du package Home V2 : les vues, le CSS et le JS sont dupliqués dans ce
 * package (dossier `welcome-home`, assets `public/css|js/welcome`).
 */
class WelcomeServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/config/welcome.php', 'welcome');
    }

    public function boot(): void
    {
        // ── Résolution DOT-NOTATION ────────────────────────────────────────────
        // @include('welcome-home.components.Header') → résolu dans ce package.
        // Ajouté en fin de liste : n'interfère pas avec les vues de l'application.
        $this->callAfterResolving('view', function ($view) {
            $view->addLocation(__DIR__ . '/resources/views');
        });

        // ── Résolution NAMESPACE (optionnelle) ─────────────────────────────────
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'welcome');

        // ── Routes du package ──────────────────────────────────────────────────
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');

        // ── Publication de la configuration ────────────────────────────────────
        $this->publishes([
            __DIR__ . '/config/welcome.php' => config_path('welcome.php'),
        ], 'welcome-config');

        // ── Publication des assets ─────────────────────────────────────────────
        // php artisan vendor:publish --tag=welcome-assets --force
        $this->publishes([
            __DIR__ . '/resources/css' => public_path('css/welcome'),
            __DIR__ . '/resources/js'  => public_path('js/welcome'),
        ], 'welcome-assets');
    }
}
