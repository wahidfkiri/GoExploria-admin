<?php 

namespace Vendor\Destination\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\Province;
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
    // Soit par la relation directe, soit par les provinces du pays
    $mapPoints = collect(); // Collection vide par défaut
    
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
    // Méthode 3: Récupérer par coordonnées géographiques (dans les limites du pays)
    else {
        // Définir les limites approximatives du pays
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
            'province' => $point->province ?? $point->ville ?? '',
            'city' => $point->ville,
            'desc' => $point->description,
            'videoId' => $point->youtube_id,
            'image' => $point->thumbnail,
            'adresse' => $point->adresse,
            'details_url' => $point->details_url,
            'has_details_page' => $point->has_details_page
        ];
    });
    
    return view('destination::index', compact('country', 'provinces', 'sliders', 'places'));
}

/**
 * Obtenir les limites géographiques approximatives d'un pays
 */
private function getCountryBounds($country)
{
    // Définir les limites pour chaque pays (vous pouvez les stocker en DB ou config)
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
        // Ajoutez d'autres pays selon vos besoins
    ];
    
    return $bounds[$country->code] ?? null;
}

    public function province(Request $request, $code)
    {
        $province = Province::where('code', $code)->firstOrFail();
        $regions = $province->regions()->get();
        return view('destination::index', compact('province', 'regions'));
    }
}