<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use App\Models\Plan;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    /**
     * Récupérer tous les sliders actifs pour le Hero
     */
    public function getHeroSliders()
    {
        $sliders = Slider::active()
            ->videos()
            ->ordered()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $sliders
        ]);
    }

    /**
     * Récupérer tous les sliders actifs
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

        return view('home-v2.index', compact('sliders', 'plans'));
    }

    /**
     * Récupérer un slider spécifique
     */
    public function show($id)
    {
        $slider = Slider::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $slider
        ]);
    }
}
