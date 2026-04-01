<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Continent;
use App\Models\Country;
use App\Models\Province;
use App\Models\Region;
use App\Models\Ville;

class DestinationDataSeeder extends Seeder
{
    public function run()
    {
        // Afrique
        $africa = Continent::where('code', 'AF')->first();
        if ($africa) {
            $this->seedAfrica($africa);
        }

        // Europe
        $europe = Continent::where('code', 'EU')->first();
        if ($europe) {
            $this->seedEurope($europe);
        }

        // Asie
        $asia = Continent::where('code', 'AS')->first();
        if ($asia) {
            $this->seedAsia($asia);
        }

        // Amérique du Sud
        $southAmerica = Continent::where('code', 'SA')->first();
        if ($southAmerica) {
            $this->seedSouthAmerica($southAmerica);
        }

        // Océanie
        $oceania = Continent::where('code', 'OC')->first();
        if ($oceania) {
            $this->seedOceania($oceania);
        }
    }

    private function seedAfrica($continent)
    {
        // Maroc
        $morocco = Country::updateOrCreate(
            ['code' => 'MA', 'continent_id' => $continent->id],
            [
                'name' => 'Maroc',
                'iso2' => 'MA',
                'capital' => 'Rabat',
                'currency' => 'Dirham marocain',
                'flag' => '🇲🇦',
                'is_active' => true
            ]
        );

        $province = Province::updateOrCreate(
            ['code' => 'MA-CAS', 'country_id' => $morocco->id],
            ['name' => 'Grand Casablanca', 'capital' => 'Casablanca', 'is_active' => true]
        );

        $region = Region::updateOrCreate(
            ['code' => 'MA-CAS-R1', 'province_id' => $province->id],
            ['name' => 'Casablanca-Settat', 'capital' => 'Casablanca', 'is_active' => true]
        );

        Ville::updateOrCreate(
            ['code' => 'MA-CAS-01', 'region_id' => $region->id],
            ['name' => 'Casablanca', 'country_id' => $morocco->id, 'province_id' => $province->id, 'population' => 3600000, 'is_active' => true]
        );
        Ville::updateOrCreate(
            ['code' => 'MA-CAS-02', 'region_id' => $region->id],
            ['name' => 'Mohammedia', 'country_id' => $morocco->id, 'province_id' => $province->id, 'population' => 200000, 'is_active' => true]
        );

        // Égypte
        $egypt = Country::updateOrCreate(
            ['code' => 'EG', 'continent_id' => $continent->id],
            [
                'name' => 'Égypte',
                'iso2' => 'EG',
                'capital' => 'Le Caire',
                'currency' => 'Livre égyptienne',
                'flag_emoji' => '🇪🇬',
                'is_active' => true
            ]
        );

        $province = Province::updateOrCreate(
            ['code' => 'EG-CAI', 'country_id' => $egypt->id],
            ['name' => 'Le Caire', 'capital' => 'Le Caire', 'is_active' => true]
        );

        $region = Region::updateOrCreate(
            ['code' => 'EG-CAI-R1', 'province_id' => $province->id],
            ['name' => 'Grand Caire', 'capital' => 'Le Caire', 'is_active' => true]
        );

        Ville::updateOrCreate(
            ['code' => 'EG-CAI-01', 'region_id' => $region->id],
            ['name' => 'Le Caire', 'country_id' => $egypt->id, 'province_id' => $province->id, 'population' => 9500000, 'is_active' => true]
        );
        Ville::updateOrCreate(
            ['code' => 'EG-CAI-02', 'region_id' => $region->id],
            ['name' => 'Gizeh', 'country_id' => $egypt->id, 'province_id' => $province->id, 'population' => 3600000, 'is_active' => true]
        );

        // Afrique du Sud
        $southAfrica = Country::updateOrCreate(
            ['code' => 'ZA', 'continent_id' => $continent->id],
            [
                'name' => 'Afrique du Sud',
                'iso2' => 'ZA',
                'capital' => 'Pretoria',
                'currency' => 'Rand',
                'flag_emoji' => '🇿🇦',
                'is_active' => true
            ]
        );

        $province = Province::updateOrCreate(
            ['code' => 'ZA-GT', 'country_id' => $southAfrica->id],
            ['name' => 'Gauteng', 'capital' => 'Johannesburg', 'is_active' => true]
        );

        $region = Region::updateOrCreate(
            ['code' => 'ZA-GT-R1', 'province_id' => $province->id],
            ['name' => 'Johannesburg Metro', 'capital' => 'Johannesburg', 'is_active' => true]
        );

        Ville::updateOrCreate(
            ['code' => 'ZA-GT-01', 'region_id' => $region->id],
            ['name' => 'Johannesburg', 'country_id' => $southAfrica->id, 'province_id' => $province->id, 'population' => 5600000, 'is_active' => true]
        );
        Ville::updateOrCreate(
            ['code' => 'ZA-GT-02', 'region_id' => $region->id],
            ['name' => 'Pretoria', 'country_id' => $southAfrica->id, 'province_id' => $province->id, 'population' => 2900000, 'is_active' => true]
        );
    }

    private function seedEurope($continent)
    {
        // France
        $france = Country::updateOrCreate(
            ['code' => 'FR', 'continent_id' => $continent->id],
            [
                'name' => 'France',
                'iso2' => 'FR',
                'capital' => 'Paris',
                'currency' => 'Euro',
                'flag_emoji' => '🇫🇷',
                'is_active' => true
            ]
        );

        $province = Province::updateOrCreate(
            ['code' => 'FR-IDF', 'country_id' => $france->id],
            ['name' => 'Île-de-France', 'capital' => 'Paris', 'is_active' => true]
        );

        $region = Region::updateOrCreate(
            ['code' => 'FR-IDF-R1', 'province_id' => $province->id],
            ['name' => 'Paris et Petite Couronne', 'capital' => 'Paris', 'is_active' => true]
        );

        Ville::updateOrCreate(
            ['code' => 'FR-PAR-01', 'region_id' => $region->id],
            ['name' => 'Paris', 'country_id' => $france->id, 'province_id' => $province->id, 'population' => 2200000, 'is_active' => true]
        );
        Ville::updateOrCreate(
            ['code' => 'FR-PAR-02', 'region_id' => $region->id],
            ['name' => 'Versailles', 'country_id' => $france->id, 'province_id' => $province->id, 'population' => 85000, 'is_active' => true]
        );
        Ville::updateOrCreate(
            ['code' => 'FR-PAR-03', 'region_id' => $region->id],
            ['name' => 'Boulogne-Billancourt', 'country_id' => $france->id, 'province_id' => $province->id, 'population' => 120000, 'is_active' => true]
        );

        // Espagne
        $spain = Country::updateOrCreate(
            ['code' => 'ES', 'continent_id' => $continent->id],
            [
                'name' => 'Espagne',
                'iso2' => 'ES',
                'capital' => 'Madrid',
                'currency' => 'Euro',
                'flag_emoji' => '🇪🇸',
                'is_active' => true
            ]
        );

        $province = Province::updateOrCreate(
            ['code' => 'ES-MD', 'country_id' => $spain->id],
            ['name' => 'Communauté de Madrid', 'capital' => 'Madrid', 'is_active' => true]
        );

        $region = Region::updateOrCreate(
            ['code' => 'ES-MD-R1', 'province_id' => $province->id],
            ['name' => 'Madrid Métropolitain', 'capital' => 'Madrid', 'is_active' => true]
        );

        Ville::updateOrCreate(
            ['code' => 'ES-MD-01', 'region_id' => $region->id],
            ['name' => 'Madrid', 'country_id' => $spain->id, 'province_id' => $province->id, 'population' => 3300000, 'is_active' => true]
        );
        Ville::updateOrCreate(
            ['code' => 'ES-MD-02', 'region_id' => $region->id],
            ['name' => 'Alcalá de Henares', 'country_id' => $spain->id, 'province_id' => $province->id, 'population' => 195000, 'is_active' => true]
        );

        // Italie
        $italy = Country::updateOrCreate(
            ['code' => 'IT', 'continent_id' => $continent->id],
            [
                'name' => 'Italie',
                'iso2' => 'IT',
                'capital' => 'Rome',
                'currency' => 'Euro',
                'flag_emoji' => '🇮🇹',
                'is_active' => true
            ]
        );

        $province = Province::updateOrCreate(
            ['code' => 'IT-RM', 'country_id' => $italy->id],
            ['name' => 'Latium', 'capital' => 'Rome', 'is_active' => true]
        );

        $region = Region::updateOrCreate(
            ['code' => 'IT-RM-R1', 'province_id' => $province->id],
            ['name' => 'Rome Capitale', 'capital' => 'Rome', 'is_active' => true]
        );

        Ville::updateOrCreate(
            ['code' => 'IT-RM-01', 'region_id' => $region->id],
            ['name' => 'Rome', 'country_id' => $italy->id, 'province_id' => $province->id, 'population' => 2870000, 'is_active' => true]
        );
        Ville::updateOrCreate(
            ['code' => 'IT-RM-02', 'region_id' => $region->id],
            ['name' => 'Ostia', 'country_id' => $italy->id, 'province_id' => $province->id, 'population' => 85000, 'is_active' => true]
        );
    }

    private function seedAsia($continent)
    {
        // Japon
        $japan = Country::updateOrCreate(
            ['code' => 'JP', 'continent_id' => $continent->id],
            [
                'name' => 'Japon',
                'iso2' => 'JP',
                'capital' => 'Tokyo',
                'currency' => 'Yen',
                'flag_emoji' => '🇯🇵',
                'is_active' => true
            ]
        );

        $province = Province::updateOrCreate(
            ['code' => 'JP-13', 'country_id' => $japan->id],
            ['name' => 'Tokyo', 'capital' => 'Tokyo', 'is_active' => true]
        );

        $region = Region::updateOrCreate(
            ['code' => 'JP-13-R1', 'province_id' => $province->id],
            ['name' => 'Tokyo Métropole', 'capital' => 'Tokyo', 'is_active' => true]
        );

        Ville::updateOrCreate(
            ['code' => 'JP-13-01', 'region_id' => $region->id],
            ['name' => 'Tokyo', 'country_id' => $japan->id, 'province_id' => $province->id, 'population' => 13960000, 'is_active' => true]
        );
        Ville::updateOrCreate(
            ['code' => 'JP-13-02', 'region_id' => $region->id],
            ['name' => 'Shibuya', 'country_id' => $japan->id, 'province_id' => $province->id, 'population' => 230000, 'is_active' => true]
        );
        Ville::updateOrCreate(
            ['code' => 'JP-13-03', 'region_id' => $region->id],
            ['name' => 'Shinjuku', 'country_id' => $japan->id, 'province_id' => $province->id, 'population' => 340000, 'is_active' => true]
        );

        // Chine
        $china = Country::updateOrCreate(
            ['code' => 'CN', 'continent_id' => $continent->id],
            [
                'name' => 'Chine',
                'iso2' => 'CN',
                'capital' => 'Pékin',
                'currency' => 'Yuan',
                'flag_emoji' => '🇨🇳',
                'is_active' => true
            ]
        );

        $province = Province::updateOrCreate(
            ['code' => 'CN-BJ', 'country_id' => $china->id],
            ['name' => 'Pékin', 'capital' => 'Pékin', 'is_active' => true]
        );

        $region = Region::updateOrCreate(
            ['code' => 'CN-BJ-R1', 'province_id' => $province->id],
            ['name' => 'Pékin Centre', 'capital' => 'Pékin', 'is_active' => true]
        );

        Ville::updateOrCreate(
            ['code' => 'CN-BJ-01', 'region_id' => $region->id],
            ['name' => 'Pékin', 'country_id' => $china->id, 'province_id' => $province->id, 'population' => 21540000, 'is_active' => true]
        );
        Ville::updateOrCreate(
            ['code' => 'CN-BJ-02', 'region_id' => $region->id],
            ['name' => 'Chaoyang', 'country_id' => $china->id, 'province_id' => $province->id, 'population' => 3700000, 'is_active' => true]
        );

        // Thaïlande
        $thailand = Country::updateOrCreate(
            ['code' => 'TH', 'continent_id' => $continent->id],
            [
                'name' => 'Thaïlande',
                'iso2' => 'TH',
                'capital' => 'Bangkok',
                'currency' => 'Baht',
                'flag_emoji' => '🇹🇭',
                'is_active' => true
            ]
        );

        $province = Province::updateOrCreate(
            ['code' => 'TH-10', 'country_id' => $thailand->id],
            ['name' => 'Bangkok', 'capital' => 'Bangkok', 'is_active' => true]
        );

        $region = Region::updateOrCreate(
            ['code' => 'TH-10-R1', 'province_id' => $province->id],
            ['name' => 'Bangkok Métropole', 'capital' => 'Bangkok', 'is_active' => true]
        );

        Ville::updateOrCreate(
            ['code' => 'TH-10-01', 'region_id' => $region->id],
            ['name' => 'Bangkok', 'country_id' => $thailand->id, 'province_id' => $province->id, 'population' => 10700000, 'is_active' => true]
        );
        Ville::updateOrCreate(
            ['code' => 'TH-10-02', 'region_id' => $region->id],
            ['name' => 'Pattaya', 'country_id' => $thailand->id, 'province_id' => $province->id, 'population' => 120000, 'is_active' => true]
        );
    }

    private function seedSouthAmerica($continent)
    {
        // Brésil
        $brazil = Country::updateOrCreate(
            ['code' => 'BR', 'continent_id' => $continent->id],
            [
                'name' => 'Brésil',
                'iso2' => 'BR',
                'capital' => 'Brasília',
                'currency' => 'Real brésilien',
                'flag_emoji' => '🇧🇷',
                'is_active' => true
            ]
        );

        $province = Province::updateOrCreate(
            ['code' => 'BR-SP', 'country_id' => $brazil->id],
            ['name' => 'São Paulo', 'capital' => 'São Paulo', 'is_active' => true]
        );

        $region = Region::updateOrCreate(
            ['code' => 'BR-SP-R1', 'province_id' => $province->id],
            ['name' => 'Grande São Paulo', 'capital' => 'São Paulo', 'is_active' => true]
        );

        Ville::updateOrCreate(
            ['code' => 'BR-SP-01', 'region_id' => $region->id],
            ['name' => 'São Paulo', 'country_id' => $brazil->id, 'province_id' => $province->id, 'population' => 12300000, 'is_active' => true]
        );
        Ville::updateOrCreate(
            ['code' => 'BR-SP-02', 'region_id' => $region->id],
            ['name' => 'Guarulhos', 'country_id' => $brazil->id, 'province_id' => $province->id, 'population' => 1400000, 'is_active' => true]
        );

        // Argentine
        $argentina = Country::updateOrCreate(
            ['code' => 'AR', 'continent_id' => $continent->id],
            [
                'name' => 'Argentine',
                'iso2' => 'AR',
                'capital' => 'Buenos Aires',
                'currency' => 'Peso argentin',
                'flag_emoji' => '🇦🇷',
                'is_active' => true
            ]
        );

        $province = Province::updateOrCreate(
            ['code' => 'AR-BA', 'country_id' => $argentina->id],
            ['name' => 'Buenos Aires', 'capital' => 'Buenos Aires', 'is_active' => true]
        );

        $region = Region::updateOrCreate(
            ['code' => 'AR-BA-R1', 'province_id' => $province->id],
            ['name' => 'Grand Buenos Aires', 'capital' => 'Buenos Aires', 'is_active' => true]
        );

        Ville::updateOrCreate(
            ['code' => 'AR-BA-01', 'region_id' => $region->id],
            ['name' => 'Buenos Aires', 'country_id' => $argentina->id, 'province_id' => $province->id, 'population' => 3100000, 'is_active' => true]
        );
        Ville::updateOrCreate(
            ['code' => 'AR-BA-02', 'region_id' => $region->id],
            ['name' => 'La Plata', 'country_id' => $argentina->id, 'province_id' => $province->id, 'population' => 650000, 'is_active' => true]
        );
    }

    private function seedOceania($continent)
    {
        // Australie
        $australia = Country::updateOrCreate(
            ['code' => 'AU', 'continent_id' => $continent->id],
            [
                'name' => 'Australie',
                'iso2' => 'AU',
                'capital' => 'Canberra',
                'currency' => 'Dollar australien',
                'flag_emoji' => '🇦🇺',
                'is_active' => true
            ]
        );

        $province = Province::updateOrCreate(
            ['code' => 'AU-NSW', 'country_id' => $australia->id],
            ['name' => 'Nouvelle-Galles du Sud', 'capital' => 'Sydney', 'is_active' => true]
        );

        $region = Region::updateOrCreate(
            ['code' => 'AU-NSW-R1', 'province_id' => $province->id],
            ['name' => 'Sydney Métropole', 'capital' => 'Sydney', 'is_active' => true]
        );

        Ville::updateOrCreate(
            ['code' => 'AU-NSW-01', 'region_id' => $region->id],
            ['name' => 'Sydney', 'country_id' => $australia->id, 'province_id' => $province->id, 'population' => 5300000, 'is_active' => true]
        );
        Ville::updateOrCreate(
            ['code' => 'AU-NSW-02', 'region_id' => $region->id],
            ['name' => 'Newcastle', 'country_id' => $australia->id, 'province_id' => $province->id, 'population' => 320000, 'is_active' => true]
        );

        // Nouvelle-Zélande
        $newZealand = Country::updateOrCreate(
            ['code' => 'NZ', 'continent_id' => $continent->id],
            [
                'name' => 'Nouvelle-Zélande',
                'iso2' => 'NZ',
                'capital' => 'Wellington',
                'currency' => 'Dollar néo-zélandais',
                'flag_emoji' => '🇳🇿',
                'is_active' => true
            ]
        );

        $province = Province::updateOrCreate(
            ['code' => 'NZ-AUK', 'country_id' => $newZealand->id],
            ['name' => 'Auckland', 'capital' => 'Auckland', 'is_active' => true]
        );

        $region = Region::updateOrCreate(
            ['code' => 'NZ-AUK-R1', 'province_id' => $province->id],
            ['name' => 'Auckland Métropole', 'capital' => 'Auckland', 'is_active' => true]
        );

        Ville::updateOrCreate(
            ['code' => 'NZ-AUK-01', 'region_id' => $region->id],
            ['name' => 'Auckland', 'country_id' => $newZealand->id, 'province_id' => $province->id, 'population' => 1660000, 'is_active' => true]
        );
        Ville::updateOrCreate(
            ['code' => 'NZ-AUK-02', 'region_id' => $region->id],
            ['name' => 'Manukau', 'country_id' => $newZealand->id, 'province_id' => $province->id, 'population' => 400000, 'is_active' => true]
        );
    }
}
