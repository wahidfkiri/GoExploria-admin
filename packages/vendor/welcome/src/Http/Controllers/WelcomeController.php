<?php

namespace Vendor\Welcome\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Slider;

/**
 * Contrôleur de la page /welcome.
 *
 * Rend un clone indépendant de la page d'accueil (design identique à « / »).
 * Réutilise uniquement les MODÈLES de l'application (couche données partagée),
 * jamais le code du package Home V2. Les vues clonées vivent sous `welcome-home`.
 */
class WelcomeController extends Controller
{
    public function index()
    {
        $sliders = $this->safe(fn () => Slider::active()->ordered()->get(), collect());

        $plans = $this->safe(fn () => Plan::active()
            ->ordered()
            ->with([
                'activeDestinations',
                'plugins' => fn ($q) => $q->orderBy('name'),
            ])
            ->get(), collect());

        $naMap = $this->safe(fn () => $this->northAmericaMapData(), null);

        return view('welcome-home.index', compact('sliders', 'plans', 'naMap'));
    }

    /**
     * Données légères pour la carte Amérique du Nord (points chargés en AJAX).
     */
    protected function northAmericaMapData(): ?array
    {
        $slug = config('welcome.map.continent_slug', 'amerique-du-nord');

        $continent = \App\Helpers\DestinationHelper::continent($slug)
            ?? app(\App\Services\DestinationService::class)->getContinentBySlug($slug);

        if (! $continent) {
            return null;
        }

        return [
            'entity'         => $continent,
            'slug'           => $continent->slug ?? $slug,
            'normalizedType' => 'continent',
            'childEntities'  => $continent->countries()->active()->get(),
            'mapCategories'  => \App\Models\MapCategory::where('is_active', true)
                ->orderBy('sort_order')
                ->get(['slug', 'name', 'icon_class', 'color', 'image']),
        ];
    }

    protected function safe(callable $callback, mixed $fallback): mixed
    {
        try {
            return $callback();
        } catch (\Throwable $e) {
            return $fallback;
        }
    }
}
