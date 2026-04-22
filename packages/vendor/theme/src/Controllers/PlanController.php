<?php

namespace Vendor\Theme\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Plugin;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    /**
     * Affiche le détail d'un plan spécifique
     */
    public function show($slug = null)
    {
        // Si un slug est fourni, on cherche ce plan
        if ($slug) {
            $plan = Plan::where('slug', $slug)
                ->with('plugins')
                ->firstOrFail();
        } else {
            // Sinon, on prend le premier plan actif
            $plan = Plan::active()
                ->with('plugins')
                ->firstOrFail();
        }
        
        return view('theme::plans.plan-detail', compact('plan'));
    }

    
    public function preview($id = null)
    {
            $plan = Plan::active()
                ->with('plugins')
                ->firstOrFail();
        
        return view('theme::plans.plan-' . $id, compact('plan'));
    }


}