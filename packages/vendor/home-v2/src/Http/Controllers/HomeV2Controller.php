<?php

namespace Vendor\HomeV2\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\Category;
use App\Models\Activity;

class HomeV2Controller extends Controller
{
    /**
     * Afficher la page d'accueil v2 avec les sliders
     */
    public function index()
    {
        $sliders = Slider::active()
            ->videos()
            ->ordered()
            ->get();

        return view('home-v2.index', compact('sliders'));
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
