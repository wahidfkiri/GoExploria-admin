<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\HasPage;

class Quartier extends Model
{
    use HasFactory, SoftDeletes, HasPage;

    protected $connection = 'mysql';

    protected $fillable = [
        'name',
        'code',
        'classification',
        'population',
        'area',
        'households',
        'density',
        'mayor',
        'website',
        'image',
        'description',
        'history',
        'attractions',
        'transport',
        'education',
        'parks',
        'latitude',
        'longitude',
        'is_active',
        'arrondissement_id',
        'ville_id'
    ];

    protected $casts = [
        'population' => 'integer',
        'area' => 'decimal:2',
        'households' => 'integer',
        'density' => 'decimal:2',
        'is_active' => 'boolean'
    ];

    // Relation avec l'arrondissement
    public function arrondissement(): BelongsTo
    {
        return $this->belongsTo(Arrondissement::class);
    }

    // Relation directe avec la ville (raccourci pour filtres)
    public function ville(): BelongsTo
    {
        return $this->belongsTo(Ville::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Accessor pour le nom complet
    public function getFullNameAttribute(): string
    {
        return "{$this->name} ({$this->code})";
    }

    // Accessor pour les coordonnées
    public function getCoordinatesAttribute(): string
    {
        if ($this->latitude && $this->longitude) {
            return "{$this->latitude}, {$this->longitude}";
        }
        return 'Non disponible';
    }

    // Accessor pour Google Maps URL
    public function getGoogleMapsUrlAttribute(): ?string
    {
        if ($this->latitude && $this->longitude) {
            return "https://www.google.com/maps?q={$this->latitude},{$this->longitude}";
        }
        return null;
    }

    // Calcul de la densité
    public function calculateDensity(): void
    {
        if ($this->population && $this->area && $this->area > 0) {
            $this->density = round($this->population / $this->area, 2);
        }
    }

    // Scope pour les quartiers d'un arrondissement spécifique
    public function scopeByArrondissement($query, $arrondissementCode)
    {
        return $query->whereHas('arrondissement', function ($q) use ($arrondissementCode) {
            $q->where('code', $arrondissementCode);
        });
    }

    // Scope pour les quartiers d'une ville spécifique
    public function scopeByVille($query, $villeCode)
    {
        return $query->whereHas('ville', function ($q) use ($villeCode) {
            $q->where('code', $villeCode);
        });
    }

    // Événement de modèle - calcul automatique de la densité
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($quartier) {
            $quartier->calculateDensity();
        });
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image) return null;
        if (str_starts_with($this->image, 'http')) return $this->image;
        return asset('storage/' . $this->image);
    }
}
