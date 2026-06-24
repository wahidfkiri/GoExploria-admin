<?php

namespace App\Services;

use App\Models\Continent;
use App\Models\Country;
use App\Models\Province;
use App\Models\Region;
use App\Models\Ville;
use App\Models\Secteur;
use App\Models\Etablissement;
use App\Models\Activity;
use Vendor\Cms\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Collection;

/**
 * Service de gestion des destinations géographiques
 * Fournit une couche d'abstraction pour accéder aux données géographiques
 * avec mise en cache pour optimiser les performances
 */
class DestinationService
{
    /**
     * Durée du cache en secondes (24 heures)
     */
    const CACHE_DURATION = 86400;

    /**
     * Récupérer tous les continents actifs
     */
    public function getContinents(bool $withRelations = false): Collection
    {
        $cacheKey = 'destinations.continents.' . ($withRelations ? 'with_relations' : 'simple');
        
        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($withRelations) {
            $query = Continent::active()->orderBy('name');
            
            if ($withRelations) {
                $query->with(['countries' => function ($q) {
                    $q->active()->orderBy('name');
                }]);
            }
            
            return $query->get();
        });
    }

    /**
     * Récupérer un continent par son ID ou code
     */
    public function getContinent($identifier, bool $withRelations = false)
    {
        $cacheKey = "destinations.continent.{$identifier}." . ($withRelations ? 'with_relations' : 'simple');
        
        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($identifier, $withRelations) {
            $query = Continent::active();
            
            if ($withRelations) {
                $query->with(['countries' => function ($q) {
                    $q->active()->orderBy('name');
                }]);
            }
            
            return is_numeric($identifier) 
                ? $query->find($identifier)
                : $query->where('code', $identifier)->first();
        });
    }

    /**
     * Récupérer tous les pays actifs
     */
    public function getCountries(?int $continentId = null, bool $withRelations = false): Collection
    {
        $cacheKey = 'destinations.countries.' . ($continentId ?? 'all') . '.' . ($withRelations ? 'with_relations' : 'simple');
        
        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($continentId, $withRelations) {
            $query = Country::active()->orderBy('name');
            
            if ($continentId) {
                $query->where('continent_id', $continentId);
            }
            
            if ($withRelations) {
                $query->with(['continent', 'provinces' => function ($q) {
                    $q->active()->orderBy('name');
                }]);
            }
            
            return $query->get();
        });
    }

    /**
     * Récupérer un pays par son ID ou code
     */
    public function getCountry($identifier, bool $withRelations = false)
    {
        $cacheKey = "destinations.country.{$identifier}." . ($withRelations ? 'with_relations' : 'simple');
        
        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($identifier, $withRelations) {
            $query = Country::active();
            
            if ($withRelations) {
                $query->with([
                    'continent',
                    'provinces' => function ($q) {
                        $q->active()->orderBy('name');
                    }
                ]);
            }
            
            return is_numeric($identifier) 
                ? $query->find($identifier)
                : $query->where('code', $identifier)->orWhere('iso2', $identifier)->first();
        });
    }

    /**
     * Récupérer toutes les provinces actives
     */
    public function getProvinces(?int $countryId = null, bool $withRelations = false): Collection
    {
        $cacheKey = 'destinations.provinces.' . ($countryId ?? 'all') . '.' . ($withRelations ? 'with_relations' : 'simple');
        
        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($countryId, $withRelations) {
            $query = Province::active()->orderBy('name');
            
            if ($countryId) {
                $query->where('country_id', $countryId);
            }
            
            if ($withRelations) {
                $query->with(['country', 'regions' => function ($q) {
                    $q->active()->orderBy('name');
                }]);
            }
            
            return $query->get();
        });
    }

    /**
     * Récupérer une province par son ID ou code
     */
    public function getProvince($identifier, bool $withRelations = false)
    {
        $cacheKey = "destinations.province.{$identifier}." . ($withRelations ? 'with_relations' : 'simple');
        
        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($identifier, $withRelations) {
            $query = Province::active();
            
            if ($withRelations) {
                $query->with([
                    'country',
                    'regions' => function ($q) {
                        $q->active()->orderBy('name');
                    }
                ]);
            }
            
            return is_numeric($identifier) 
                ? $query->find($identifier)
                : $query->where('code', $identifier)->first();
        });
    }

    /**
     * Récupérer toutes les régions actives
     */
    public function getRegions(?int $provinceId = null, bool $withRelations = false): Collection
    {
        $cacheKey = 'destinations.regions.' . ($provinceId ?? 'all') . '.' . ($withRelations ? 'with_relations' : 'simple');
        
        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($provinceId, $withRelations) {
            $query = Region::active()->orderBy('name');
            
            if ($provinceId) {
                $query->where('province_id', $provinceId);
            }
            
            if ($withRelations) {
                $query->with(['province', 'villes' => function ($q) {
                    $q->active()->orderBy('name');
                }]);
            }
            
            return $query->get();
        });
    }

    /**
     * Récupérer une région par son ID ou code
     */
    public function getRegion($identifier, bool $withRelations = false)
    {
        $cacheKey = "destinations.region.{$identifier}." . ($withRelations ? 'with_relations' : 'simple');
        
        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($identifier, $withRelations) {
            $query = Region::active();
            
            if ($withRelations) {
                $query->with([
                    'province',
                    'villes' => function ($q) {
                        $q->active()->orderBy('name');
                    },
                    'secteurs' => function ($q) {
                        $q->active()->orderBy('name');
                    }
                ]);
            }
            
            return is_numeric($identifier) 
                ? $query->find($identifier)
                : $query->where('code', $identifier)->first();
        });
    }

    /**
     * Récupérer toutes les villes actives
     */
    public function getVilles(?int $regionId = null, bool $withRelations = false): Collection
    {
        $cacheKey = 'destinations.villes.' . ($regionId ?? 'all') . '.' . ($withRelations ? 'with_relations' : 'simple');
        
        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($regionId, $withRelations) {
            $query = Ville::active()->orderBy('name');
            
            if ($regionId) {
                $query->where('region_id', $regionId);
            }
            
            if ($withRelations) {
                $query->with(['region', 'province', 'country', 'secteur']);
            }
            
            return $query->get();
        });
    }

    /**
     * Récupérer une ville par son ID ou code
     */
    public function getVille($identifier, bool $withRelations = false)
    {
        $cacheKey = "destinations.ville.{$identifier}." . ($withRelations ? 'with_relations' : 'simple');
        
        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($identifier, $withRelations) {
            $query = Ville::active();
            
            if ($withRelations) {
                $query->with(['region', 'province', 'country', 'secteur']);
            }
            
            return is_numeric($identifier) 
                ? $query->find($identifier)
                : $query->where('code', $identifier)->first();
        });
    }

    /**
     * Récupérer tous les secteurs actifs
     */
    public function getSecteurs(?int $regionId = null, bool $withRelations = false): Collection
    {
        $cacheKey = 'destinations.secteurs.' . ($regionId ?? 'all') . '.' . ($withRelations ? 'with_relations' : 'simple');
        
        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($regionId, $withRelations) {
            $query = Secteur::active()->orderBy('name');
            
            if ($regionId) {
                $query->where('region_id', $regionId);
            }
            
            if ($withRelations) {
                $query->with(['region', 'villes' => function ($q) {
                    $q->active()->orderBy('name');
                }]);
            }
            
            return $query->get();
        });
    }

    /**
     * Récupérer un secteur par son ID ou code
     */
    public function getSecteur($identifier, bool $withRelations = false)
    {
        $cacheKey = "destinations.secteur.{$identifier}." . ($withRelations ? 'with_relations' : 'simple');
        
        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($identifier, $withRelations) {
            $query = Secteur::active();
            
            if ($withRelations) {
                $query->with(['region', 'villes' => function ($q) {
                    $q->active()->orderBy('name');
                }]);
            }
            
            return is_numeric($identifier) 
                ? $query->find($identifier)
                : $query->where('code', $identifier)->first();
        });
    }

    /**
     * Rechercher des destinations par nom
     */
    public function search(string $query, ?string $type = null): array
    {
        $results = [];
        
        try {
            if (!$type || $type === 'continent') {
                $results['continents'] = Continent::active()
                    ->where('name', 'like', "%{$query}%")
                    ->limit(10)
                    ->get();
            }
        } catch (\Exception $e) {
            $results['continents'] = collect([]);
        }
        
        try {
            if (!$type || $type === 'country') {
                $results['countries'] = Country::active()
                    ->where('name', 'like', "%{$query}%")
                    ->limit(10)
                    ->get();
            }
        } catch (\Exception $e) {
            $results['countries'] = collect([]);
        }
        
        try {
            if (!$type || $type === 'province') {
                $results['provinces'] = Province::active()
                    ->where('name', 'like', "%{$query}%")
                    ->limit(10)
                    ->get();
            }
        } catch (\Exception $e) {
            $results['provinces'] = collect([]);
        }
        
        try {
            if (!$type || $type === 'region') {
                $results['regions'] = Region::active()
                    ->where('name', 'like', "%{$query}%")
                    ->limit(10)
                    ->get();
            }
        } catch (\Exception $e) {
            $results['regions'] = collect([]);
        }
        
        try {
            if (!$type || $type === 'ville') {
                $results['villes'] = Ville::active()
                    ->where('name', 'like', "%{$query}%")
                    ->limit(10)
                    ->get();
            }
        } catch (\Exception $e) {
            $results['villes'] = collect([]);
        }
        
        try {
            if (!$type || $type === 'secteur') {
                $results['secteurs'] = Secteur::active()
                    ->where('name', 'like', "%{$query}%")
                    ->limit(10)
                    ->get();
            }
        } catch (\Exception $e) {
            $results['secteurs'] = collect([]);
        }

        try {
            if (!$type || $type === 'etablissement') {
                $etablissementIdsBySiteName = Setting::query()
                    ->where('group', 'general')
                    ->whereIn('key', ['name', 'site_name'])
                    ->where('value', 'like', "%{$query}%")
                    ->pluck('etablissement_id')
                    ->filter()
                    ->unique()
                    ->values();

                $etablissements = Etablissement::query()
                    ->where('is_active', true)
                    ->where(function ($builder) use ($query, $etablissementIdsBySiteName) {
                        $builder->where('name', 'like', "%{$query}%")
                            ->orWhere('lname', 'like', "%{$query}%")
                            ->orWhere('other_activity_label', 'like', "%{$query}%")
                            ->orWhere('ville', 'like', "%{$query}%")
                            ->orWhereIn('id', $etablissementIdsBySiteName);
                    })
                    ->orderBy('name')
                    ->limit(10)
                    ->get(['id', 'name', 'lname', 'ville', 'adresse', 'is_active']);

                if ($etablissements->isNotEmpty()) {
                    $ids = $etablissements->pluck('id')->all();
                    $rawSettings = Setting::query()
                        ->whereIn('etablissement_id', $ids)
                        ->where('group', 'general')
                        ->whereIn('key', ['name', 'site_name', 'site_logo'])
                        ->get(['etablissement_id', 'key', 'value']);

                    $siteNamesById = [];
                    $logosById = [];
                    foreach ($rawSettings as $setting) {
                        $eid = (int) $setting->etablissement_id;
                        $value = trim((string) $setting->value);
                        if ($value === '') {
                            continue;
                        }

                        if ($setting->key === 'site_logo') {
                            $logosById[$eid] = $value;
                            continue;
                        }

                        // Priority: key=name, fallback key=site_name.
                        if (($setting->key === 'name') || !isset($siteNamesById[$eid])) {
                            $siteNamesById[$eid] = $value;
                        }
                    }

                    $etablissements->transform(function ($item) use ($siteNamesById, $logosById) {
                        $item->site_name = $siteNamesById[(int) $item->id] ?? null;

                        $rawLogo = trim((string) ($logosById[(int) $item->id] ?? ''));
                        if ($rawLogo !== '') {
                            if (filter_var($rawLogo, FILTER_VALIDATE_URL)) {
                                $item->logo_url = $rawLogo;
                            } else {
                                $item->logo_url = Storage::disk('public')->url($rawLogo);
                            }
                        } else {
                            $item->logo_url = null;
                        }

                        return $item;
                    });
                }

                $results['etablissements'] = $etablissements;
            }
        } catch (\Exception $e) {
            $results['etablissements'] = collect([]);
        }

        try {
            if (!$type || $type === 'activity') {
                $results['activities'] = Activity::active()
                    ->where('name', 'like', "%{$query}%")
                    ->limit(10)
                    ->get(['id', 'name', 'slug', 'description', 'image', 'is_active']);
            }
        } catch (\Exception $e) {
            $results['activities'] = collect([]);
        }

        return $results;
    }

    /**
     * Vider le cache des destinations
     */
    public function clearCache(): void
    {
        Cache::tags(['destinations'])->flush();
    }

    /**
     * Récupérer la hiérarchie complète d'une destination
     */
    public function getHierarchy(string $type, $identifier): ?array
    {
        switch ($type) {
            case 'ville':
                $ville = $this->getVille($identifier, true);
                if (!$ville) return null;
                
                return [
                    'ville' => $ville,
                    'secteur' => $ville->secteur,
                    'region' => $ville->region,
                    'province' => $ville->province,
                    'country' => $ville->country,
                    'continent' => $ville->country->continent ?? null
                ];
                
            case 'secteur':
                $secteur = $this->getSecteur($identifier, true);
                if (!$secteur) return null;
                
                return [
                    'secteur' => $secteur,
                    'region' => $secteur->region,
                    'province' => $secteur->region->province ?? null,
                    'country' => $secteur->region->province->country ?? null,
                    'continent' => $secteur->region->province->country->continent ?? null
                ];
                
            case 'region':
                $region = $this->getRegion($identifier, true);
                if (!$region) return null;
                
                return [
                    'region' => $region,
                    'province' => $region->province,
                    'country' => $region->province->country ?? null,
                    'continent' => $region->province->country->continent ?? null
                ];
                
            case 'province':
                $province = $this->getProvince($identifier, true);
                if (!$province) return null;
                
                return [
                    'province' => $province,
                    'country' => $province->country,
                    'continent' => $province->country->continent ?? null
                ];
                
            case 'country':
                $country = $this->getCountry($identifier, true);
                if (!$country) return null;
                
                return [
                    'country' => $country,
                    'continent' => $country->continent
                ];
                
            default:
                return null;
        }
    }

    /**
     * Récupérer un continent par son slug
     */
    private function resolveGeoBySlug(string $modelClass, string $slug)
    {
        $model = new $modelClass();
        $table = $model->getTable();
        $rawSlug = trim($slug);
        $normalizedSlug = Str::slug($rawSlug);
        $baseQuery = $modelClass::active();

        if (Schema::hasColumn($table, 'slug')) {
            $bySlug = (clone $baseQuery)->where('slug', $rawSlug)->first();
            if ($bySlug) {
                return $bySlug;
            }

            if ($normalizedSlug !== $rawSlug) {
                $byNormalizedSlug = (clone $baseQuery)->where('slug', $normalizedSlug)->first();
                if ($byNormalizedSlug) {
                    return $byNormalizedSlug;
                }
            }
        }

        if (Schema::hasColumn($table, 'code')) {
            $byCode = (clone $baseQuery)
                ->whereRaw('LOWER(code) = ?', [Str::lower($rawSlug)])
                ->first();

            if ($byCode) {
                return $byCode;
            }
        }

        if (!Schema::hasColumn($table, 'name')) {
            return null;
        }

        return $baseQuery->get()->first(function ($item) use ($normalizedSlug, $rawSlug) {
            $name = (string) ($item->name ?? '');
            $nameSlug = Str::slug($name);

            if ($nameSlug === $normalizedSlug || Str::lower($name) === Str::lower($rawSlug)) {
                return true;
            }

            $code = (string) ($item->code ?? '');
            return $code !== '' && Str::slug($code) === $normalizedSlug;
        });
    }

    public function getContinentBySlug(string $slug)
    {
        $cacheKey = "destinations.continent.slug.{$slug}";
        
        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($slug) {
            return $this->resolveGeoBySlug(Continent::class, $slug);
        });
    }

    /**
     * Récupérer un pays par son slug
     */
    public function getCountryBySlug(string $slug)
    {
        $cacheKey = "destinations.country.slug.{$slug}";
        
        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($slug) {
            return $this->resolveGeoBySlug(Country::class, $slug);
        });
    }

    /**
     * Récupérer une province par son slug
     */
    public function getProvinceBySlug(string $slug)
    {
        $cacheKey = "destinations.province.slug.{$slug}";
        
        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($slug) {
            return $this->resolveGeoBySlug(Province::class, $slug);
        });
    }

    /**
     * Récupérer une région par son slug
     */
    public function getRegionBySlug(string $slug)
    {
        $cacheKey = "destinations.region.slug.{$slug}";
        
        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($slug) {
            return $this->resolveGeoBySlug(Region::class, $slug);
        });
    }

    /**
     * Récupérer une ville par son slug
     */
    public function getVilleBySlug(string $slug)
    {
        $cacheKey = "destinations.ville.slug.{$slug}";
        
        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($slug) {
            return $this->resolveGeoBySlug(Ville::class, $slug);
        });
    }

    /**
     * Récupérer un secteur par son slug
     */
    public function getSecteurBySlug(string $slug)
    {
        $cacheKey = "destinations.secteur.slug.{$slug}";
        
        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($slug) {
            return $this->resolveGeoBySlug(Secteur::class, $slug);
        });
    }

    /**
     * Récupérer tous les continents (alias pour compatibilité)
     */
    public function getAllContinents(bool $withRelations = false): Collection
    {
        return $this->getContinents($withRelations);
    }

    /**
     * Récupérer les pays d'un continent
     */
    public function getCountriesByContinent($continentId, bool $withRelations = false): Collection
    {
        $cacheKey = "destinations.continent.{$continentId}.countries." . ($withRelations ? 'with_relations' : 'simple');
        
        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($continentId, $withRelations) {
            $query = Country::active()->where('continent_id', $continentId)->orderBy('name');
            
            if ($withRelations) {
                $query->with(['provinces' => function ($q) {
                    $q->active()->orderBy('name');
                }]);
            }
            
            return $query->get();
        });
    }

    /**
     * Récupérer les provinces d'un pays
     */
    public function getProvincesByCountry($countryId, bool $withRelations = false): Collection
    {
        $cacheKey = "destinations.country.{$countryId}.provinces." . ($withRelations ? 'with_relations' : 'simple');
        
        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($countryId, $withRelations) {
            $query = Province::active()->where('country_id', $countryId)->orderBy('name');
            
            if ($withRelations) {
                $query->with(['regions' => function ($q) {
                    $q->active()->orderBy('name');
                }]);
            }
            
            return $query->get();
        });
    }

    /**
     * Récupérer les régions d'une province
     */
    public function getRegionsByProvince($provinceId, bool $withRelations = false): Collection
    {
        $cacheKey = "destinations.province.{$provinceId}.regions." . ($withRelations ? 'with_relations' : 'simple');
        
        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($provinceId, $withRelations) {
            $query = Region::active()->where('province_id', $provinceId)->orderBy('name');
            
            if ($withRelations) {
                $query->with(['villes' => function ($q) {
                    $q->active()->orderBy('name');
                }]);
            }
            
            return $query->get();
        });
    }

    /**
     * Récupérer les villes d'une région
     */
    public function getVillesByRegion($regionId, bool $withRelations = false): Collection
    {
        $cacheKey = "destinations.region.{$regionId}.villes." . ($withRelations ? 'with_relations' : 'simple');
        
        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($regionId, $withRelations) {
            $query = Ville::active()->where('region_id', $regionId)->orderBy('name');
            
            if ($withRelations) {
                $query->with(['secteurs' => function ($q) {
                    $q->active()->orderBy('name');
                }]);
            }
            
            return $query->get();
        });
    }

    /**
     * Récupérer les secteurs d'une ville
     */
    public function getSecteursByVille($villeId, bool $withRelations = false): Collection
    {
        $cacheKey = "destinations.ville.{$villeId}.secteurs." . ($withRelations ? 'with_relations' : 'simple');
        
        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($villeId, $withRelations) {
            $ville = Ville::active()->find($villeId);
            $query = Secteur::active()->orderBy('name');
            $secteurTable = (new Secteur())->getTable();

            if (Schema::hasColumn($secteurTable, 'ville_id')) {
                $query->where('ville_id', $villeId);
            } elseif ($ville && $ville->region_id) {
                $query->where('region_id', $ville->region_id);
            } else {
                return collect();
            }
            
            if ($withRelations) {
                $query->with(['region', 'villes' => function ($q) {
                    $q->active()->orderBy('name');
                }]);
            }
            
            return $query->get();
        });
    }
}
