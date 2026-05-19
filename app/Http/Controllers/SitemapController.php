<?php

namespace App\Http\Controllers;

use App\Models\Continent;
use App\Models\Country;
use App\Models\Etablissement;
use App\Models\Province;
use App\Models\Region;
use App\Models\Secteur;
use App\Models\Ville;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Vendor\Cms\Models\Page;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $sitemaps = [
            ['loc' => url('/sitemaps/core.xml'), 'lastmod' => now()->toAtomString()],
            ['loc' => url('/sitemaps/destinations.xml'), 'lastmod' => now()->toAtomString()],
            ['loc' => url('/sitemaps/companies.xml'), 'lastmod' => now()->toAtomString()],
        ];

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($sitemaps as $map) {
            $xml .= "  <sitemap>\n";
            $xml .= '    <loc>' . $this->escapeXml($map['loc']) . "</loc>\n";
            $xml .= '    <lastmod>' . $map['lastmod'] . "</lastmod>\n";
            $xml .= "  </sitemap>\n";
        }

        $xml .= '</sitemapindex>';

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }

    public function core(): Response
    {
        $urls = [
            ['loc' => url('/'), 'priority' => '1.0'],
            ['loc' => url('/devis'), 'priority' => '0.9'],
            ['loc' => url('/valeurs'), 'priority' => '0.8'],
            ['loc' => url('/categories'), 'priority' => '0.8'],
            ['loc' => url('/destinations'), 'priority' => '0.9'],
            ['loc' => url('/contact'), 'priority' => '0.7'],
        ];

        return $this->buildUrlset($urls);
    }

    public function destinations(): Response
    {
        $urls = [];

        $urls[] = ['loc' => url('/destinations'), 'priority' => '0.9'];

        $urls = array_merge($urls, $this->buildDestinationUrls(Continent::class, 'continent'));
        $urls = array_merge($urls, $this->buildDestinationUrls(Country::class, 'pays'));
        $urls = array_merge($urls, $this->buildDestinationUrls(Province::class, 'province'));
        $urls = array_merge($urls, $this->buildDestinationUrls(Region::class, 'region'));
        $urls = array_merge($urls, $this->buildDestinationUrls(Ville::class, 'ville'));
        $urls = array_merge($urls, $this->buildDestinationUrls(Secteur::class, 'secteur'));
        $urls = array_merge($urls, $this->buildHierarchicalDestinationUrls());

        return $this->buildUrlset($urls);
    }

    public function companies(): Response
    {
        $urls = [];

        $etablissements = Etablissement::query()
            ->where('is_active', true)
            ->select(['id', 'name', 'updated_at'])
            ->orderBy('id')
            ->get();

        foreach ($etablissements as $etablissement) {
            $slug = Str::slug((string) ($etablissement->name ?? 'etablissement-' . $etablissement->id));
            $urls[] = [
                'loc' => url('/company/' . $etablissement->id . '/' . ($slug ?: ('etablissement-' . $etablissement->id))),
                'lastmod' => optional($etablissement->updated_at)->toAtomString(),
                'priority' => '0.8',
            ];
        }

        try {
            $pages = Page::query()
                ->where('status', 'published')
                ->where('visibility', 'public')
                ->whereNotNull('slug')
                ->select(['etablissement_id', 'slug', 'updated_at'])
                ->orderBy('updated_at', 'desc')
                ->get();

            foreach ($pages as $page) {
                if (!$page->etablissement_id || !$page->slug) {
                    continue;
                }

                $urls[] = [
                    'loc' => url('/company/' . $page->etablissement_id . '/page/' . ltrim((string) $page->slug, '/')),
                    'lastmod' => optional($page->updated_at)->toAtomString(),
                    'priority' => '0.7',
                ];
            }
        } catch (\Throwable $exception) {
            // Keep companies sitemap available even if cms connection is temporarily unavailable.
        }

        return $this->buildUrlset($urls);
    }

    private function buildDestinationUrls(string $modelClass, string $segment): array
    {
        $model = new $modelClass();
        $table = $model->getTable();
        $hasSlug = Schema::hasColumn($table, 'slug');
        $select = ['id', 'name', 'updated_at'];

        if ($hasSlug) {
            $select[] = 'slug';
        }

        $items = $modelClass::query()
            ->where('is_active', true)
            ->select($select)
            ->orderBy('id')
            ->get();

        $urls = [];

        foreach ($items as $item) {
            $slug = $hasSlug
                ? (string) ($item->slug ?? '')
                : Str::slug((string) ($item->name ?? ''));

            if ($slug === '') {
                $slug = 'item-' . $item->id;
            }

            $urls[] = [
                'loc' => url('/destinations/' . $segment . '/' . $slug),
                'lastmod' => optional($item->updated_at)->toAtomString(),
                'priority' => '0.7',
            ];
        }

        return $urls;
    }

    private function buildHierarchicalDestinationUrls(): array
    {
        $urls = [];

        $continents = Continent::query()
            ->where('is_active', true)
            ->with(['countries' => function ($countryQuery) {
                $countryQuery->where('is_active', true)
                    ->with(['provinces' => function ($provinceQuery) {
                        $provinceQuery->where('is_active', true)
                            ->with(['regions' => function ($regionQuery) {
                                $regionQuery->where('is_active', true)
                                    ->with([
                                        'villes' => function ($villeQuery) {
                                            $villeQuery->where('is_active', true);
                                        },
                                        'secteurs' => function ($secteurQuery) {
                                            $secteurQuery->where('is_active', true);
                                        },
                                    ]);
                            }]);
                    }]);
            }])
            ->get();

        foreach ($continents as $continent) {
            $continentPath = $this->destinationSlug($continent);
            $urls[] = $this->destinationUrlPayload($continentPath, $continent, '0.8');

            foreach ($continent->countries as $country) {
                $countryPath = $continentPath . '/' . $this->destinationSlug($country);
                $urls[] = $this->destinationUrlPayload($countryPath, $country, '0.8');

                foreach ($country->provinces as $province) {
                    $provincePath = $countryPath . '/' . $this->destinationSlug($province);
                    $urls[] = $this->destinationUrlPayload($provincePath, $province, '0.7');

                    foreach ($province->regions as $region) {
                        $regionPath = $provincePath . '/' . $this->destinationSlug($region);
                        $urls[] = $this->destinationUrlPayload($regionPath, $region, '0.7');

                        foreach ($region->villes as $ville) {
                            $villePath = $regionPath . '/' . $this->destinationSlug($ville);
                            $urls[] = $this->destinationUrlPayload($villePath, $ville, '0.6');

                            $villeSecteurs = $region->secteurs->filter(function ($secteur) use ($ville) {
                                return !isset($secteur->ville_id) || (int) $secteur->ville_id === (int) $ville->id;
                            });

                            foreach ($villeSecteurs as $secteur) {
                                $urls[] = $this->destinationUrlPayload($villePath . '/' . $this->destinationSlug($secteur), $secteur, '0.6');
                            }
                        }
                    }
                }
            }
        }

        return $urls;
    }

    private function destinationUrlPayload(string $path, $model, string $priority): array
    {
        return [
            'loc' => url('/' . ltrim($path, '/')),
            'lastmod' => optional($model->updated_at)->toAtomString(),
            'priority' => $priority,
        ];
    }

    private function destinationSlug($model): string
    {
        $slug = trim((string) ($model->slug ?? ''));

        if ($slug !== '') {
            return Str::slug($slug);
        }

        return Str::slug((string) ($model->name ?? $model->code ?? ('destination-' . $model->id)));
    }

    private function buildUrlset(array $urls): Response
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($urls as $url) {
            $xml .= "  <url>\n";
            $xml .= '    <loc>' . $this->escapeXml($url['loc']) . "</loc>\n";

            if (!empty($url['lastmod'])) {
                $xml .= '    <lastmod>' . $url['lastmod'] . "</lastmod>\n";
            }

            if (!empty($url['priority'])) {
                $xml .= '    <priority>' . $url['priority'] . "</priority>\n";
            }

            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }

    private function escapeXml(string $value): string
    {
        return htmlspecialchars($value, ENT_XML1 | ENT_QUOTES, 'UTF-8');
    }
}
