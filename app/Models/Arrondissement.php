<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\HasPage;

class Arrondissement extends Model
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
        'ville_id'
    ];

    protected $casts = [
        'population' => 'integer',
        'area' => 'decimal:2',
        'households' => 'integer',
        'density' => 'decimal:2',
        'is_active' => 'boolean'
    ];

    // Relation avec la ville (municipalité)

    /**
     * Activités rattachées à ce niveau.
     *
     * ⚠ Le pivot n'existe que depuis la migration du 2026-09-30 ; il est
     * alimenté par l'onglet « Catégories & Activités » de l'espace
     * destination. Sans cette relation, TravelDestinationController
     * retombait sur une collection vide (garde `method_exists`) et le
     * méga-menu des activités ne s'affichait jamais à ce niveau.
     */
    public function activities(): BelongsToMany
    {
        return $this->belongsToMany(Activity::class, 'activity_arrondissement')
                    ->withTimestamps();
    }

    public function ville(): BelongsTo
    {
        return $this->belongsTo(Ville::class);
    }

    // Relation avec les quartiers
    public function quartiers(): HasMany
    {
        return $this->hasMany(Quartier::class);
    }

    // Accessor pour le nombre de quartiers
    public function getQuartiersCountAttribute(): int
    {
        return $this->quartiers()->count();
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

    // Accessor : URL OpenStreetMap du point
    public function getGoogleMapsUrlAttribute(): ?string
    {
        if ($this->latitude && $this->longitude) {
            return "https://www.openstreetmap.org/?mlat={$this->latitude}&mlon={$this->longitude}#map=15/{$this->latitude}/{$this->longitude}";
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

    // Scope pour les arrondissements d'une ville spécifique
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

        static::saving(function ($arrondissement) {
            $arrondissement->calculateDensity();
        });
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image) return null;
        if (str_starts_with($this->image, 'http')) return $this->image;
        return asset('storage/' . $this->image);
    }
}
