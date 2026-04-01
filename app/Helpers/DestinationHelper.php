<?php

namespace App\Helpers;

use App\Services\DestinationService;
use Illuminate\Support\Facades\App;

/**
 * Helper pour les destinations géographiques
 * Fournit des fonctions utilitaires réutilisables dans toute la plateforme
 */
class DestinationHelper
{
    protected static ?DestinationService $service = null;

    /**
     * Obtenir l'instance du service
     */
    protected static function getService(): DestinationService
    {
        if (self::$service === null) {
            self::$service = App::make(DestinationService::class);
        }
        return self::$service;
    }

    /**
     * Récupérer tous les continents actifs
     */
    public static function continents(bool $withRelations = false)
    {
        return self::getService()->getContinents($withRelations);
    }

    /**
     * Récupérer un continent
     */
    public static function continent($identifier, bool $withRelations = false)
    {
        return self::getService()->getContinent($identifier, $withRelations);
    }

    /**
     * Récupérer tous les pays actifs
     */
    public static function countries(?int $continentId = null, bool $withRelations = false)
    {
        return self::getService()->getCountries($continentId, $withRelations);
    }

    /**
     * Récupérer un pays
     */
    public static function country($identifier, bool $withRelations = false)
    {
        return self::getService()->getCountry($identifier, $withRelations);
    }

    /**
     * Récupérer toutes les provinces actives
     */
    public static function provinces(?int $countryId = null, bool $withRelations = false)
    {
        return self::getService()->getProvinces($countryId, $withRelations);
    }

    /**
     * Récupérer une province
     */
    public static function province($identifier, bool $withRelations = false)
    {
        return self::getService()->getProvince($identifier, $withRelations);
    }

    /**
     * Récupérer toutes les régions actives
     */
    public static function regions(?int $provinceId = null, bool $withRelations = false)
    {
        return self::getService()->getRegions($provinceId, $withRelations);
    }

    /**
     * Récupérer une région
     */
    public static function region($identifier, bool $withRelations = false)
    {
        return self::getService()->getRegion($identifier, $withRelations);
    }

    /**
     * Récupérer toutes les villes actives
     */
    public static function villes(?int $regionId = null, bool $withRelations = false)
    {
        return self::getService()->getVilles($regionId, $withRelations);
    }

    /**
     * Récupérer une ville
     */
    public static function ville($identifier, bool $withRelations = false)
    {
        return self::getService()->getVille($identifier, $withRelations);
    }

    /**
     * Récupérer tous les secteurs actifs
     */
    public static function secteurs(?int $regionId = null, bool $withRelations = false)
    {
        return self::getService()->getSecteurs($regionId, $withRelations);
    }

    /**
     * Récupérer un secteur
     */
    public static function secteur($identifier, bool $withRelations = false)
    {
        return self::getService()->getSecteur($identifier, $withRelations);
    }

    /**
     * Rechercher des destinations
     */
    public static function search(string $query, ?string $type = null)
    {
        return self::getService()->search($query, $type);
    }

    /**
     * Récupérer la hiérarchie complète d'une destination
     */
    public static function hierarchy(string $type, $identifier)
    {
        return self::getService()->getHierarchy($type, $identifier);
    }

    /**
     * Formater un nom de destination avec sa hiérarchie
     * Ex: "Montréal, QC, Canada"
     */
    public static function formatFullName($destination, string $type): string
    {
        if (!$destination) {
            return '';
        }

        switch ($type) {
            case 'ville':
                $parts = [$destination->name];
                if ($destination->province) {
                    $parts[] = $destination->province->code;
                }
                if ($destination->country) {
                    $parts[] = $destination->country->name;
                }
                return implode(', ', $parts);

            case 'region':
                $parts = [$destination->name];
                if ($destination->province) {
                    $parts[] = $destination->province->name;
                }
                return implode(', ', $parts);

            case 'province':
                $parts = [$destination->name];
                if ($destination->country) {
                    $parts[] = $destination->country->name;
                }
                return implode(', ', $parts);

            case 'country':
                return $destination->name;

            default:
                return $destination->name ?? '';
        }
    }

    /**
     * Générer un breadcrumb pour une destination
     */
    public static function breadcrumb($destination, string $type): array
    {
        $hierarchy = self::hierarchy($type, $destination->id);
        
        if (!$hierarchy) {
            return [];
        }

        $breadcrumb = [];

        if (isset($hierarchy['continent'])) {
            $breadcrumb[] = [
                'name' => $hierarchy['continent']->name,
                'type' => 'continent',
                'id' => $hierarchy['continent']->id
            ];
        }

        if (isset($hierarchy['country'])) {
            $breadcrumb[] = [
                'name' => $hierarchy['country']->name,
                'type' => 'country',
                'id' => $hierarchy['country']->id
            ];
        }

        if (isset($hierarchy['province'])) {
            $breadcrumb[] = [
                'name' => $hierarchy['province']->name,
                'type' => 'province',
                'id' => $hierarchy['province']->id
            ];
        }

        if (isset($hierarchy['region'])) {
            $breadcrumb[] = [
                'name' => $hierarchy['region']->name,
                'type' => 'region',
                'id' => $hierarchy['region']->id
            ];
        }

        if (isset($hierarchy['secteur'])) {
            $breadcrumb[] = [
                'name' => $hierarchy['secteur']->name,
                'type' => 'secteur',
                'id' => $hierarchy['secteur']->id
            ];
        }

        if (isset($hierarchy['ville'])) {
            $breadcrumb[] = [
                'name' => $hierarchy['ville']->name,
                'type' => 'ville',
                'id' => $hierarchy['ville']->id
            ];
        }

        return $breadcrumb;
    }

    /**
     * Vérifier si une destination a des coordonnées GPS
     */
    public static function hasCoordinates($destination): bool
    {
        return !empty($destination->latitude) && !empty($destination->longitude);
    }

    /**
     * Obtenir l'URL Google Maps d'une destination
     */
    public static function googleMapsUrl($destination): ?string
    {
        if (!self::hasCoordinates($destination)) {
            return null;
        }

        return "https://www.google.com/maps?q={$destination->latitude},{$destination->longitude}";
    }

    /**
     * Formater la population avec séparateurs de milliers
     */
    public static function formatPopulation(?int $population): string
    {
        if (!$population) {
            return 'Non disponible';
        }

        return number_format($population, 0, ',', ' ') . ' habitants';
    }

    /**
     * Formater la superficie
     */
    public static function formatArea($area): string
    {
        if (!$area) {
            return 'Non disponible';
        }

        return number_format($area, 2, ',', ' ') . ' km²';
    }

    /**
     * Calculer et formater la densité de population
     */
    public static function formatDensity(?int $population, $area): string
    {
        if (!$population || !$area || $area <= 0) {
            return 'Non disponible';
        }

        $density = $population / $area;
        return number_format($density, 2, ',', ' ') . ' hab/km²';
    }
}
