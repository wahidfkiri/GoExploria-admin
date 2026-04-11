<?php

namespace Vendor\HomeV2\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Slider;

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
}
