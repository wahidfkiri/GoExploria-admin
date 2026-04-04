<?php 

namespace Vendor\Destination\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\Province;
use App\Models\Region;
use App\Models\Slider;
use App\Models\MapPoint;


class DestinationController extends Controller
{
    public function countrie(Request $request, $code)
    {
        $country = Country::where('code', $code)->firstOrFail();
        $provinces = $country->provinces()->get();
        
        $sliders = Slider::active()
            ->videos()
            ->ordered()
            ->get();
        
        // Récupérer les points de la carte pour ce pays
        $mapPoints = collect();
        
        // Méthode 1: Si MapPoint a une relation avec Province
        if (method_exists(MapPoint::class, 'province')) {
            $provinceIds = $provinces->pluck('id')->toArray();
            $mapPoints = MapPoint::active()
                ->whereHas('province', function($query) use ($provinceIds) {
                    $query->whereIn('id', $provinceIds);
                })
                ->with(['images', 'videos'])
                ->get();
        } 
        // Méthode 2: Si MapPoint a une relation directe avec Country
        elseif (method_exists(MapPoint::class, 'country')) {
            $mapPoints = MapPoint::active()
                ->where('country_id', $country->id)
                ->with(['images', 'videos'])
                ->get();
        }
        // Méthode 3: Récupérer par coordonnées géographiques
        else {
            $bounds = $this->getCountryBounds($country);
            if ($bounds) {
                $mapPoints = MapPoint::active()
                    ->whereBetween('latitude', [$bounds['min_lat'], $bounds['max_lat']])
                    ->whereBetween('longitude', [$bounds['min_lng'], $bounds['max_lng']])
                    ->with(['images', 'videos'])
                    ->get();
            }
        }
        
        // Transformer les données pour JavaScript
        $places = $mapPoints->map(function($point) {
            return [
                'id' => $point->id,
                'name' => $point->title,
                'lat' => (float)$point->latitude,
                'lng' => (float)$point->longitude,
                'category' => $point->category,
                'province' => $point->province ? $point->province->name : ($point->ville ?? ''),
                'city' => $point->ville,
                'desc' => $point->description,
                'videoId' => $point->youtube_id,
                'image' => $point->thumbnail,
                'adresse' => $point->adresse,
                'details_url' => $point->details_url,
                'has_details_page' => $point->has_details_page
            ];
        });
        
        return view('destination::countries.index', compact('country', 'provinces', 'sliders', 'places'));
    }

    public function province(Request $request, $countryCode, $code)
    {
        // Récupérer la province par son code
        $province = Province::where('code', $code)->firstOrFail();
        $country = Country::where('code', $countryCode)->firstOrFail();
        
        // Récupérer les régions de cette province
        $regions = $province->regions()->get();
        
        $sliders = Slider::active()
            ->videos()
            ->ordered()
            ->get();
        
        // Récupérer les points de la carte pour cette province
        $mapPoints = collect();
        
        // Méthode 1: MapPoint a une relation directe avec Province
        if (method_exists(MapPoint::class, 'province')) {
            $mapPoints = MapPoint::active()
                ->where('province_id', $province->id)
                ->with(['images', 'videos'])
                ->get();
        } 
        // Méthode 2: MapPoint a une relation avec Region
        elseif (method_exists(MapPoint::class, 'region') && $regions->isNotEmpty()) {
            $regionIds = $regions->pluck('id')->toArray();
            $mapPoints = MapPoint::active()
                ->whereHas('region', function($query) use ($regionIds) {
                    $query->whereIn('id', $regionIds);
                })
                ->with(['images', 'videos'])
                ->get();
        }
        // Méthode 3: Récupérer par coordonnées géographiques (dans les limites de la province)
        else {
            $bounds = $this->getProvinceBounds($province);
            if ($bounds) {
                $mapPoints = MapPoint::active()
                    ->whereBetween('latitude', [$bounds['min_lat'], $bounds['max_lat']])
                    ->whereBetween('longitude', [$bounds['min_lng'], $bounds['max_lng']])
                    ->with(['images', 'videos'])
                    ->get();
            }
        }
        
        // Transformer les données pour JavaScript
        $places = $mapPoints->map(function($point) use ($province) {
            return [
                'id' => $point->id,
                'name' => $point->title,
                'lat' => (float)$point->latitude,
                'lng' => (float)$point->longitude,
                'category' => $point->category,
                'province' => $province->name,
                'region' => $point->region ? $point->region->name : ($point->ville ?? ''),
                'city' => $point->ville,
                'desc' => $point->description,
                'videoId' => $point->youtube_id,
                'image' => $point->thumbnail,
                'adresse' => $point->adresse,
                'details_url' => $point->details_url,
                'has_details_page' => $point->has_details_page
            ];
        });
        
        return view('destination::provinces.index', compact('country', 'province', 'regions', 'sliders', 'places'));
    }

    /**
     * Obtenir les limites géographiques approximatives d'un pays
     */
    private function getCountryBounds($country)
    {
        $bounds = [
            'CAN' => [ // Canada
                'min_lat' => 41.6766,
                'max_lat' => 83.1106,
                'min_lng' => -141.0027,
                'max_lng' => -52.3232
            ],
            'USA' => [ // États-Unis
                'min_lat' => 24.3963,
                'max_lat' => 49.3844,
                'min_lng' => -124.8489,
                'max_lng' => -66.8854
            ],
            'FRA' => [ // France
                'min_lat' => 41.333,
                'max_lat' => 51.124,
                'min_lng' => -5.142,
                'max_lng' => 9.562
            ],
        ];
        
        return $bounds[$country->code] ?? null;
    }

    /**
     * Obtenir les limites géographiques approximatives d'une province
     */
    private function getProvinceBounds($province)
    {
        // Vous pouvez définir les limites pour chaque province
        $bounds = [
            'QC' => [ // Québec
                'min_lat' => 45.0,
                'max_lat' => 62.6,
                'min_lng' => -79.8,
                'max_lng' => -57.1
            ],
            'ON' => [ // Ontario
                'min_lat' => 41.7,
                'max_lat' => 56.9,
                'min_lng' => -95.2,
                'max_lng' => -74.3
            ],
            'BC' => [ // Colombie-Britannique
                'min_lat' => 48.3,
                'max_lat' => 60.0,
                'min_lng' => -139.1,
                'max_lng' => -114.0
            ],
            'AB' => [ // Alberta
                'min_lat' => 49.0,
                'max_lat' => 60.0,
                'min_lng' => -120.0,
                'max_lng' => -110.0
            ],
            // Ajoutez les autres provinces selon vos besoins
        ];
        
        return $bounds[$province->code] ?? null;
    }
}