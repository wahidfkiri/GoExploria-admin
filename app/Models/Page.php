<?php
// app/Models/Page.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Vendor\Cms\Models\Traits\StockeEnFichiers;

class Page extends Model
{
    use StockeEnFichiers;

    /*
     * Stockage des contenus (base | fichiers) : une page de destination
     * appartient à sa destination, désignée par pageable_type + pageable_id.
     * Cf. Vendor\Cms\Contenus\StockageContenus.
     */
    public function proprietaireContenus(): ?array
    {
        $type = (string) $this->getAttribute('pageable_type');
        $id = (int) $this->getAttribute('pageable_id');

        return $type !== '' && $id > 0 ? [$type, $id] : null;
    }

    public static function filtrerParProprietaireContenus($requete, string $type, int $id)
    {
        return $requete->where('pageable_type', $type)->where('pageable_id', $id);
    }

    protected $fillable = [
        'name',
        'slug',
        'html_content',
        'css_content',
        'is_active',
        // Marque LA page de destination issue du gabarit « Carnet d'Atlas »
        // (une seule par destination) face aux pages visuelles libres.
        'is_default',
        'pageable_id',
        'pageable_type'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_default' => 'boolean'
    ];

    /**
     * Relation polymorphique
     */
    public function pageable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Scope pour les pages actives
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope pour rechercher par slug
     */
    public function scopeBySlug($query, $slug)
    {
        return $query->where('slug', $slug);
    }

    /**
     * Récupérer le contenu HTML avec CSS intégré
     */
    public function getFullHtmlAttribute()
    {
        if ($this->css_content) {
            return '<style>' . $this->css_content . '</style>' . $this->html_content;
        }
        
        return $this->html_content;
    }
}