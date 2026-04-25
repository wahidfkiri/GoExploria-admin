<?php
// Vendor/Theme/Controllers/PlanController.php

namespace Vendor\Theme\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Plugin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

class PlanController extends Controller
{
    /**
     * Affiche le détail d'un plan spécifique
     */
    public function show($identifier = null)
    {
        try {
            // Si un identifiant est fourni, on cherche ce plan (id numérique ou slug)
            if ($identifier !== null && $identifier !== '') {
                $planQuery = Plan::with('plugins');

                if (is_numeric($identifier)) {
                    $plan = $planQuery->where('id', (int) $identifier)->firstOrFail();
                } else {
                    $plan = $planQuery->where('slug', $identifier)->firstOrFail();
                }
            } else {
                // Sinon, on prend le premier plan actif
                $plan = Plan::active()
                    ->with('plugins')
                    ->firstOrFail();
            }
            
            // Récupérer les destinations via DB direct
            $destinations = $this->getDestinationsForPlan($plan->id);
            
            return view('theme::plans.plan-detail', compact('plan', 'destinations'));
            
        } catch (\Exception $e) {
            Log::error('PlanController error: ' . $e->getMessage());
            abort(404, 'Plan non trouvé');
        }
    }
    
    /**
     * Récupère les destinations d'un plan via DB direct
     */
    private function getDestinationsForPlan($planId)
    {
        // Vérifier si la table existe
        if (!Schema::hasTable('plan_destination')) {
            return collect();
        }
        
        try {
            $destinations = DB::table('plan_destination')
                ->where('plan_id', $planId)
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->get()
                ->map(function ($item) {
                    // Convertir en objet stdClass avec des propriétés accessibles
                    return (object) [
                        'id' => $item->id,
                        'destination_name' => $item->destination_name,
                        'destination_slug' => $item->destination_slug,
                        'destination_image' => $item->destination_image,
                        'destination_description' => $item->destination_description,
                        'destination_country' => $item->destination_country,
                        'destination_city' => $item->destination_city,
                        'sort_order' => $item->sort_order,
                        'is_active' => $item->is_active,
                    ];
                });
                
            return $destinations;
            
        } catch (\Exception $e) {
            Log::warning('Erreur lors de la récupération des destinations: ' . $e->getMessage());
            return collect();
        }
    }
}
