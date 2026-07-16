<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Service (côté FRONT) — lit la table partagée `services` (base demo_laravel,
 * alimentée par l'admin /services). Sert la liste dans le menu vertical et la
 * page landing de détail.
 */
class Service extends Model
{
    use SoftDeletes;

    protected $table = 'services';

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    public function pageContents()
    {
        return $this->hasMany(ServicePageContent::class, 'service_id');
    }

    public function activeContents()
    {
        return $this->pageContents()->where('is_active', true)->orderBy('order');
    }

    public function getImageUrlAttribute(): ?string
    {
        return self::resolveMediaUrl($this->image);
    }

    /**
     * Construit l'URL d'un média stocké par l'admin. Les fichiers sont uploadés
     * sur le storage de l'admin (domaines/stockages distincts) ⇒ on préfixe par
     * ADMIN_ASSET_URL si défini, sinon on retombe sur asset() local.
     */
    public static function resolveMediaUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }
        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }
        $path = ltrim($path, '/');
        if (Str::startsWith($path, 'storage/')) {
            $path = substr($path, strlen('storage/'));
        }
        $base = rtrim((string) env('ADMIN_ASSET_URL', ''), '/');
        if ($base !== '') {
            return $base . '/storage/' . $path;
        }
        return asset('storage/' . $path);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('name');
    }
}
