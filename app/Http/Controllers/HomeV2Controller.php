<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;

class HomeV2Controller extends Controller
{
    /**
     * Afficher la page d'accueil v2 avec les sliders
     */
    public function index()
    {
        // Récupérer les sliders vidéo actifs pour le Hero
        $sliders = Slider::active()
            ->videos()
            ->ordered()
            ->get();

        return view('home-v2.index', compact('sliders'));
    }
}
