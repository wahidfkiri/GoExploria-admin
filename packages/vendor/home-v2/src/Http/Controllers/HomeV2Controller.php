<?php

namespace Vendor\HomeV2\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\Category;
use App\Models\Activity;
use App\Models\Plan;

class HomeV2Controller extends Controller
{
    /**
     * Afficher la page d'accueil v2 avec les sliders
     */
    public function index()
    {
        $sliders = Slider::active()
            ->ordered()
            ->get();

        $plans = Plan::active()
            ->ordered()
            ->with([
                'activeDestinations',
                'plugins' => function ($query) {
                    $query->orderBy('name');
                }
            ])
            ->get();

        // Carte "Amérique du Nord" (même principe/design que travel-destination/continent/amerique-du-nord).
        // Les points sont chargés en AJAX côté client → aucun impact sur le temps de chargement initial.
        $naMap = $this->northAmericaMapData();

        return view('home-v2.index', compact('sliders', 'plans', 'naMap'));
    }

    /**
     * Données légères pour la carte Amérique du Nord de la page d'accueil.
     * Ne précharge pas les points (récupérés en AJAX via travel-destination.map-points).
     * Retourne null si le continent est introuvable → repli sur l'ancienne carte.
     */
    protected function northAmericaMapData(): ?array
    {
        try {
            $continent = \App\Helpers\DestinationHelper::continent('amerique-du-nord')
                ?? app(\App\Services\DestinationService::class)->getContinentBySlug('amerique-du-nord');

            if (!$continent) {
                return null;
            }

            return [
                'entity'         => $continent,
                'slug'           => $continent->slug ?? 'amerique-du-nord',
                'normalizedType' => 'continent',
                'childEntities'  => $continent->countries()->active()->get(),
                'mapCategories'  => \App\Models\MapCategory::where('is_active', true)
                    ->orderBy('sort_order')
                    ->get(['slug', 'name', 'icon_class', 'color', 'image']),
            ];
        } catch (\Throwable $e) {
            return null;
        }
    }

    /**
     * Liste de toutes les catégories actives
     */
    public function categoriesIndex()
    {
        $categories = Category::with(['activities' => function ($q) {
            $q->where('is_active', true)->orderBy('name');
        }])->where('is_active', true)->orderBy('name')->get();

        return view('home-v2.pages.categories', compact('categories'));
    }

    /**
     * Page d'une catégorie avec ses activités
     */
    public function showCategory($slug)
    {
        $category = Category::where('slug', $slug)
            ->where('is_active', true)
            ->firstOr(function () use ($slug) {
                return Category::where('id', $slug)->where('is_active', true)->firstOrFail();
            });

        $activities = $category->activities()->where('is_active', true)->orderBy('name')->get();

        return view('home-v2.pages.category', compact('category', 'activities'));
    }

    /**
     * Page d'une activité
     */
    public function showActivity($slug)
    {
        $activity = Activity::where('slug', $slug)
            ->where('is_active', true)
            ->firstOr(function () use ($slug) {
                return Activity::where('id', $slug)->where('is_active', true)->firstOrFail();
            });

        $category = $activity->categoryRelation;

        return view('home-v2.pages.activity', compact('activity', 'category'));
    }
}
