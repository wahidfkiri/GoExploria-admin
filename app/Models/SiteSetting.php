<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * Global key/value settings shared with the admin back-office
 * (admin.goexploriabusiness.com). Both apps use the same default
 * "demo_laravel" connection and the same `site_settings` table.
 *
 * On the front these values feed the /contact page (coordinates,
 * opening hours, social links) dynamically.
 */
class SiteSetting extends Model
{
    protected $table = 'site_settings';

    protected $fillable = ['key', 'value', 'group'];

    public const CACHE_KEY = 'site_settings.map';

    /**
     * Return every setting as a [key => value] array.
     * Falls back to an empty array if the table is unavailable
     * (e.g. migration not run yet) so the page never breaks.
     */
    public static function map(): array
    {
        try {
            return static::query()->pluck('value', 'key')->toArray();
        } catch (\Throwable $e) {
            return [];
        }
    }

    /**
     * Cached version used on public pages to avoid a query on every load.
     * Cache is flushed by the admin whenever a value is saved.
     */
    public static function cachedMap(): array
    {
        try {
            return Cache::remember(self::CACHE_KEY, now()->addMinutes(10), function () {
                return static::map();
            });
        } catch (\Throwable $e) {
            return static::map();
        }
    }

    /**
     * Get a single setting value with a fallback default.
     */
    public static function get(string $key, $default = null)
    {
        $map = static::cachedMap();

        return array_key_exists($key, $map) && $map[$key] !== null && $map[$key] !== ''
            ? $map[$key]
            : $default;
    }

    public static function flushCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
