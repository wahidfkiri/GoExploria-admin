<?php

namespace Vendor\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

/**
 * Annonce / popup d'un établissement (produit, image ou vidéo).
 * Stockée dans la base « cms » (partagée admin ↔ front).
 */
class Announcement extends Model
{
    use SoftDeletes;

    protected $connection = 'cms';
    protected $table = 'cms_announcements';

    public const TYPE_PRODUCT = 'product';
    public const TYPE_IMAGE   = 'image';
    public const TYPE_VIDEO   = 'video';

    public const POSITIONS = ['center', 'bottom-right', 'bottom-left'];

    protected $fillable = [
        'etablissement_id', 'type', 'title', 'message',
        'product_id', 'media_url', 'video_url', 'link_url', 'button_label',
        'position', 'dismissible', 'is_active', 'display_delay', 'order',
        'starts_at', 'ends_at', 'settings',
    ];

    protected $casts = [
        'dismissible'   => 'boolean',
        'is_active'     => 'boolean',
        'display_delay' => 'integer',
        'order'         => 'integer',
        'starts_at'     => 'datetime',
        'ends_at'       => 'datetime',
        'settings'      => 'array',
    ];

    /** Annonces actuellement affichables (actives + dans la fenêtre de dates). */
    public function scopeLive($query)
    {
        $now = now();
        return $query->where('is_active', true)
            ->where(function ($q) use ($now) {
                $q->whereNull('starts_at')->orWhere('starts_at', '<=', $now);
            })
            ->where(function ($q) use ($now) {
                $q->whereNull('ends_at')->orWhere('ends_at', '>=', $now);
            });
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderByDesc('id');
    }

    /**
     * Résout le produit (autre base) : nom, prix, image, url. Retourne null si
     * le produit n'existe plus. Aucune jointure inter-bases.
     */
    public function productData(): ?array
    {
        if ($this->type !== self::TYPE_PRODUCT || empty($this->product_id)) {
            return null;
        }

        try {
            $p = DB::table('products')->where('id', $this->product_id)->first();
        } catch (\Throwable $e) {
            return null;
        }

        if (!$p) {
            return null;
        }

        return [
            'id'    => (int) $p->id,
            'name'  => (string) ($p->name ?? ''),
            'price' => $p->price_ttc ?? $p->price_ht ?? 0,
            'image' => $p->main_image ?: $this->media_url,
            'slug'  => $p->slug ?? null,
        ];
    }
}
