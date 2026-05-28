<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Continent;
use App\Models\Country;
use App\Models\Etablissement;
use App\Models\Province;
use App\Models\Region;
use App\Models\Secteur;
use App\Models\Ville;
use App\Services\DestinationService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * API Controller pour les destinations géographiques.
 * Les réponses exposent aussi path/url afin que la recherche et les menus
 * pointent vers les pages destinations hiérarchiques.
 */
class DestinationController extends Controller
{
    protected DestinationService $destinationService;

    public function __construct(DestinationService $destinationService)
    {
        $this->destinationService = $destinationService;
    }

    public function continents(Request $request): JsonResponse
    {
        $continents = $this->destinationService->getContinents($request->boolean('with_relations', false));

        return $this->collectionResponse($continents, 'continent');
    }

    public function continent(Request $request, $identifier): JsonResponse
    {
        $continent = $this->destinationService->getContinent($identifier, $request->boolean('with_relations', false));

        if (!$continent) {
            return $this->notFound('Continent non trouvé');
        }

        return $this->itemResponse($continent, 'continent');
    }

    public function countries(Request $request): JsonResponse
    {
        $countries = $this->destinationService->getCountries(
            $request->input('continent_id'),
            $request->boolean('with_relations', false)
        );

        return $this->collectionResponse($countries, 'country');
    }

    public function country(Request $request, $identifier): JsonResponse
    {
        $country = $this->destinationService->getCountry($identifier, $request->boolean('with_relations', false));

        if (!$country) {
            return $this->notFound('Pays non trouvé');
        }

        return $this->itemResponse($country, 'country');
    }

    public function provinces(Request $request): JsonResponse
    {
        $provinces = $this->destinationService->getProvinces(
            $request->input('country_id'),
            $request->boolean('with_relations', false)
        );

        return $this->collectionResponse($provinces, 'province');
    }

    public function province(Request $request, $identifier): JsonResponse
    {
        $province = $this->destinationService->getProvince($identifier, $request->boolean('with_relations', false));

        if (!$province) {
            return $this->notFound('Province non trouvée');
        }

        return $this->itemResponse($province, 'province');
    }

    public function regions(Request $request): JsonResponse
    {
        $regions = $this->destinationService->getRegions(
            $request->input('province_id'),
            $request->boolean('with_relations', false)
        );

        return $this->collectionResponse($regions, 'region');
    }

    public function region(Request $request, $identifier): JsonResponse
    {
        $region = $this->destinationService->getRegion($identifier, $request->boolean('with_relations', false));

        if (!$region) {
            return $this->notFound('Région non trouvée');
        }

        return $this->itemResponse($region, 'region');
    }

    public function villes(Request $request): JsonResponse
    {
        $villes = $this->destinationService->getVilles(
            $request->input('region_id'),
            $request->boolean('with_relations', false)
        );

        return $this->collectionResponse($villes, 'ville');
    }

    public function ville(Request $request, $identifier): JsonResponse
    {
        $ville = $this->destinationService->getVille($identifier, $request->boolean('with_relations', false));

        if (!$ville) {
            return $this->notFound('Ville non trouvée');
        }

        return $this->itemResponse($ville, 'ville');
    }

    public function secteurs(Request $request): JsonResponse
    {
        $secteurs = $this->destinationService->getSecteurs(
            $request->input('region_id'),
            $request->boolean('with_relations', false)
        );

        return $this->collectionResponse($secteurs, 'secteur');
    }

    public function secteur(Request $request, $identifier): JsonResponse
    {
        $secteur = $this->destinationService->getSecteur($identifier, $request->boolean('with_relations', false));

        if (!$secteur) {
            return $this->notFound('Secteur non trouvé');
        }

        return $this->itemResponse($secteur, 'secteur');
    }

    public function search(Request $request): JsonResponse
    {
        $request->validate([
            'query' => 'required|string|min:2',
            'type' => 'nullable|in:continent,country,province,region,ville,secteur,etablissement',
        ]);

        $results = $this->destinationService->search(
            $request->input('query'),
            $request->input('type')
        );

        return response()->json([
            'success' => true,
            'data' => $this->enrichSearchResults($results),
            'query' => $request->input('query'),
        ]);
    }

    public function hierarchy(string $type, $identifier): JsonResponse
    {
        $validTypes = ['ville', 'secteur', 'region', 'province', 'country'];

        if (!in_array($type, $validTypes, true)) {
            return response()->json([
                'success' => false,
                'message' => 'Type invalide. Types valides: ' . implode(', ', $validTypes),
            ], 400);
        }

        $hierarchy = $this->destinationService->getHierarchy($type, $identifier);

        if (!$hierarchy) {
            return $this->notFound(ucfirst($type) . ' non trouvé(e)');
        }

        return response()->json([
            'success' => true,
            'data' => collect($hierarchy)
                ->filter(fn ($item) => $item instanceof Model)
                ->map(fn (Model $item, string $itemType) => $this->destinationPayload($item, $itemType))
                ->all(),
        ]);
    }

    public function countriesByContinent(Request $request, $identifier): JsonResponse
    {
        $countries = $this->destinationService->getCountriesByContinent($identifier, $request->boolean('with_relations', false));

        return $this->collectionResponse($countries, 'country');
    }

    public function provincesByCountry(Request $request, $identifier): JsonResponse
    {
        $provinces = $this->destinationService->getProvincesByCountry($identifier, $request->boolean('with_relations', false));

        return $this->collectionResponse($provinces, 'province');
    }

    public function regionsByProvince(Request $request, $identifier): JsonResponse
    {
        $regions = $this->destinationService->getRegionsByProvince($identifier, $request->boolean('with_relations', false));

        return $this->collectionResponse($regions, 'region');
    }

    public function villesByRegion(Request $request, $identifier): JsonResponse
    {
        $villes = $this->destinationService->getVillesByRegion($identifier, $request->boolean('with_relations', false));

        return $this->collectionResponse($villes, 'ville');
    }

    public function secteursByVille(Request $request, $identifier): JsonResponse
    {
        $ville = $this->destinationService->getVille($identifier);
        $parentPath = $ville ? $this->destinationPath($ville, 'ville') : null;
        $secteurs = $this->destinationService->getSecteursByVille($identifier, $request->boolean('with_relations', false));

        return $this->collectionResponse($secteurs, 'secteur', $parentPath);
    }

    private function collectionResponse($items, string $type, ?string $parentPath = null): JsonResponse
    {
        $data = $this->enrichCollection($items, $type, $parentPath);

        return response()->json([
            'success' => true,
            'data' => $data,
            'count' => $data->count(),
        ]);
    }

    private function itemResponse(Model $item, string $type): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->destinationPayload($item, $type),
        ]);
    }

    private function notFound(string $message): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], 404);
    }

    private function enrichSearchResults(array $results): array
    {
        return [
            'continents' => $this->enrichCollection($results['continents'] ?? collect(), 'continent'),
            'countries' => $this->enrichCollection($results['countries'] ?? collect(), 'country'),
            'provinces' => $this->enrichCollection($results['provinces'] ?? collect(), 'province'),
            'regions' => $this->enrichCollection($results['regions'] ?? collect(), 'region'),
            'villes' => $this->enrichCollection($results['villes'] ?? collect(), 'ville'),
            'secteurs' => $this->enrichCollection($results['secteurs'] ?? collect(), 'secteur'),
            'etablissements' => collect($results['etablissements'] ?? [])->map(fn ($item) => $this->establishmentPayload($item))->values(),
        ];
    }

    private function enrichCollection($items, string $type, ?string $parentPath = null): Collection
    {
        return collect($items)
            ->filter(fn ($item) => $item instanceof Model && (bool) ($item->is_active ?? true))
            ->map(fn (Model $item) => $this->destinationPayload($item, $type, $parentPath))
            ->values();
    }

    private function destinationPayload(Model $item, string $type, ?string $parentPath = null): array
    {
        $slug = $this->destinationSlug($item);
        $path = $parentPath ? trim($parentPath, '/') . '/' . $slug : $this->destinationPath($item, $type);
        $payload = $item->toArray();

        return array_merge($payload, [
            'id' => $item->getKey(),
            'name' => $this->modelName($item),
            'slug' => $slug,
            'type' => $type,
            'path' => $path,
            'url' => '/' . ltrim($path, '/'),
            'is_active' => (bool) ($item->is_active ?? true),
            'description' => $item->description ?? null,
            'latitude' => $this->numericValue($item->latitude ?? null),
            'longitude' => $this->numericValue($item->longitude ?? null),
            'image_url' => $this->imageUrl($item),
        ]);
    }

    private function establishmentPayload($item): array
    {
        $name = trim((string) (($item->site_name ?? '') ?: ($item->name ?? 'Établissement')));
        $slug = Str::slug($name ?: ($item->name ?? 'etablissement-' . $item->id));
        $payload = $item instanceof Model ? $item->toArray() : (array) $item;

        return array_merge($payload, [
            'id' => $item->id ?? null,
            'name' => $item->name ?? $name,
            'site_name' => $item->site_name ?? null,
            'slug' => $slug,
            'type' => 'etablissement',
            'url' => '/company/' . ($item->id ?? '') . '/' . $slug,
            'is_active' => (bool) ($item->is_active ?? true),
            'logo_url' => $item->logo_url ?? null,
        ]);
    }

    private function destinationSlug(Model $item): string
    {
        foreach (['slug', 'name', 'code', 'iso2'] as $field) {
            $value = trim((string) ($item->{$field} ?? ''));
            if ($value !== '') {
                return Str::slug($value);
            }
        }

        return Str::slug(class_basename($item) . '-' . $item->getKey());
    }

    private function destinationPath(Model $item, string $type): string
    {
        $slug = $this->destinationSlug($item);

        return match ($type) {
            'continent' => $slug,
            'country' => $this->joinPath($this->pathForContinent($this->continentForCountry($item)), $slug),
            'province' => $this->joinPath($this->pathForCountry($this->countryForProvince($item)), $slug),
            'region' => $this->joinPath($this->pathForProvince($this->provinceForRegion($item)), $slug),
            'ville' => $this->joinPath($this->pathForVilleParent($item), $slug),
            'secteur' => $this->joinPath($this->pathForRegion($this->regionForSecteur($item)), $slug),
            default => $slug,
        };
    }

    private function pathForContinent(?Model $continent): ?string
    {
        return $continent ? $this->destinationSlug($continent) : null;
    }

    private function pathForCountry(?Model $country): ?string
    {
        return $country ? $this->destinationPath($country, 'country') : null;
    }

    private function pathForProvince(?Model $province): ?string
    {
        return $province ? $this->destinationPath($province, 'province') : null;
    }

    private function pathForRegion(?Model $region): ?string
    {
        return $region ? $this->destinationPath($region, 'region') : null;
    }

    private function pathForVilleParent(Model $ville): ?string
    {
        if ($region = $this->regionForVille($ville)) {
            return $this->pathForRegion($region);
        }

        if ($province = $this->provinceForVille($ville)) {
            return $this->pathForProvince($province);
        }

        if ($country = $this->countryForVille($ville)) {
            return $this->pathForCountry($country);
        }

        return null;
    }

    private function continentForCountry(Model $country): ?Model
    {
        if ($country->relationLoaded('continent')) {
            return $country->continent;
        }

        return $country->continent_id ? Continent::active()->find($country->continent_id) : null;
    }

    private function countryForProvince(Model $province): ?Model
    {
        if ($province->relationLoaded('country')) {
            return $province->country;
        }

        return $province->country_id ? Country::active()->find($province->country_id) : null;
    }

    private function provinceForRegion(Model $region): ?Model
    {
        if ($region->relationLoaded('province')) {
            return $region->province;
        }

        return $region->province_id ? Province::active()->find($region->province_id) : null;
    }

    private function regionForVille(Model $ville): ?Model
    {
        if ($ville->relationLoaded('region')) {
            return $ville->region;
        }

        return $ville->region_id ? Region::active()->find($ville->region_id) : null;
    }

    private function provinceForVille(Model $ville): ?Model
    {
        if ($ville->relationLoaded('province')) {
            return $ville->province;
        }

        return $ville->province_id ? Province::active()->find($ville->province_id) : null;
    }

    private function countryForVille(Model $ville): ?Model
    {
        if ($ville->relationLoaded('country')) {
            return $ville->country;
        }

        return $ville->country_id ? Country::active()->find($ville->country_id) : null;
    }

    private function regionForSecteur(Model $secteur): ?Model
    {
        if ($secteur->relationLoaded('region')) {
            return $secteur->region;
        }

        return $secteur->region_id ? Region::active()->find($secteur->region_id) : null;
    }

    private function joinPath(?string ...$parts): string
    {
        return collect($parts)
            ->filter(fn ($part) => is_string($part) && trim($part, '/') !== '')
            ->map(fn ($part) => trim($part, '/'))
            ->implode('/');
    }

    private function imageUrl(Model $item): ?string
    {
        foreach (['image_url', 'image', 'flag', 'thumbnail', 'thumbnail_url'] as $field) {
            $value = trim((string) ($item->{$field} ?? ''));
            if ($value === '') {
                continue;
            }

            if (Str::startsWith($value, ['http://', 'https://'])) {
                return $value;
            }

            $path = preg_replace('#^(?:/)?storage/#', '', ltrim($value, '/')) ?: ltrim($value, '/');

            if (!Storage::disk('cdn')->exists($path)) {
                return null;
            }

            return route('cdn.public-file', ['path' => $path], false);
        }

        return null;
    }

    private function modelName(Model $item): string
    {
        return (string) ($item->name ?? $item->title ?? $item->code ?? 'Destination');
    }

    private function numericValue($value): ?float
    {
        return is_numeric($value) ? (float) $value : null;
    }
}
