<?php 

namespace Vendor\GeoMap\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Place;
use Vendor\GeoMap\Resources\PlaceResource;
use Illuminate\Http\Request;
use App\Models\Continent;
use App\Models\Country;
use App\Models\Province;

class GeoMapController extends Controller
{
    public function getContinent()
    {
        // Logique pour récupérer les continents
    }

    public function getCountrie($countrieCode)
    {
        $countrie = Country::where('code', strtolower($countrieCode))->first();
        if (!$countrie) {
            return abort(404, 'Country not found');
        }
        $provinces = $countrie->provinces;
        return view('geo-map::countries.index', compact('countrie', 'provinces'));
    }

    public function getProvince($countrieCode, $provinceCode)
    {
        $province = Province::with('country')->where('code', $provinceCode)->first();
        if (!$province) {
            return abort(404, 'Province not found');
        }

        return view('geo-map::provinces.index', compact('province'));
    }
}