<?php

namespace Vendor\Cms\Support;

use App\Models\Etablissement;
use Illuminate\Support\Str;
use Vendor\Cms\Models\Setting;

/**
 * Slug d'adresse d'un établissement — même règle que `SiteSlug` de l'admin
 * (colonne `etablissements.slug`, sinon nom du site, sinon nom, sinon id).
 *
 * Sert à écrire l'adresse des pages personnalisées :
 * /company/{id}/page/{page}/{slug-entreprise}. Le dernier segment est
 * informatif — la route l'accepte quel qu'il soit.
 */
final class SiteSlug
{
    /** @var array<int, string> */
    private static array $cache = [];

    public static function pourEtablissement(Etablissement $etablissement): string
    {
        $id = (int) $etablissement->id;

        if (isset(self::$cache[$id])) {
            return self::$cache[$id];
        }

        $slug = (string) $etablissement->slug;

        if ($slug === '') {
            $nomDuSite = Setting::where('etablissement_id', $id)
                ->where('group', 'general')
                ->whereIn('key', ['name', 'site_name'])
                ->orderByRaw("CASE WHEN `key` = 'name' THEN 0 ELSE 1 END")
                ->value('value');

            $slug = Str::slug((string) $nomDuSite) ?: Str::slug((string) $etablissement->name) ?: (string) $id;
        }

        return self::$cache[$id] = $slug;
    }

    /** Adresse RELATIVE d'une page personnalisée. */
    public static function cheminPage(Etablissement $etablissement, string $pageSlug): string
    {
        return '/company/' . $etablissement->id . '/page/' . $pageSlug . '/' . self::pourEtablissement($etablissement);
    }
}
