<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Une section de la page publique /welcome (après la carte). Le contenu vient
 * soit du composant Blade d'origine (`content_source = 'view'`), soit d'un
 * contenu édité en GrapeJS (`content_source = 'builder'`).
 * Partage la table `welcome_sections` de demo_laravel avec l'admin.
 */
class WelcomeSection extends Model
{
    protected $table = 'welcome_sections';

    protected $fillable = [
        'zone_id', 'name', 'slug', 'view',
        'html_content', 'css_content', 'js_content',
        'content_source', 'settings', 'icon', 'order', 'is_active',
    ];

    protected $casts = [
        'settings'  => 'array',
        'is_active' => 'boolean',
        'order'     => 'integer',
        'zone_id'   => 'integer',
    ];

    public const SOURCE_VIEW    = 'view';
    public const SOURCE_BUILDER = 'builder';

    public function zone(): BelongsTo
    {
        return $this->belongsTo(WelcomeZone::class, 'zone_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('id');
    }

    /**
     * Le contenu doit-il être rendu depuis l'éditeur GrapeJS (html/css/js)
     * plutôt que depuis le composant Blade d'origine ?
     */
    public function usesBuilder(): bool
    {
        return $this->content_source === self::SOURCE_BUILDER
            && filled($this->html_content);
    }
}
