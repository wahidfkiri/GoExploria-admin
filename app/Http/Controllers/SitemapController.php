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
