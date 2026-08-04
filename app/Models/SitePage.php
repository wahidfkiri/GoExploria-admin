<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Page fixe du site public (/valeurs, …), éditable dans l'administration.
 *
 * Le contenu provient soit de la vue Blade d'origine du front
 * (`content_source = 'view'`), soit de l'éditeur visuel
 * (`content_source = 'builder'`). Tant qu'une page n'a pas été reprise dans
 * l'éditeur, le front la rend exactement comme avant.
 */
class SitePage extends Model
{
    protected $table = 'site_pages';

    protected $fillable = [
        'slug',
        'name',
        'description',
        'view',
        'html_content',
        'css_content',
        'content_source',
        'meta_title',
        'meta_description',
        'icon',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order'     => 'integer',
    ];

    public const SOURCE_VIEW    = 'view';
    public const SOURCE_BUILDER = 'builder';

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('name');
    }

    /**
     * La page doit-elle être rendue depuis l'éditeur ?
     *
     * On exige un contenu non vide en plus du drapeau : une page basculée en
     * « builder » puis vidée afficherait sinon une page blanche là où la vue
     * Blade d'origine reste disponible.
     */
    public function usesBuilder(): bool
    {
        return $this->content_source === self::SOURCE_BUILDER
            && trim((string) $this->html_content) !== '';
    }

    /** Contenu complet à injecter dans le front, CSS compris. */
    public function renderedContent(): string
    {
        $css = trim((string) $this->css_content);

        return ($css !== '' ? '<style>' . $css . '</style>' : '')
            . (string) $this->html_content;
    }
}
