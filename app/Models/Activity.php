<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Activity extends Model
{
    protected $fillable = [
        'name',
        'categorie_id',
        'slug',
        'is_active',
    ];

    
    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relation avec le modèle Category
    public function categorie()
    {
        return $this->belongsTo(Category::class);
    }

    // Génération automatique du slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($activity) {
            $activity->slug = Str::slug($activity->name);
        });

        static::updating(function ($activity) {
            $activity->slug = Str::slug($activity->name);
        });
    }

    /**
     * Relation Many-to-Many avec les établissements
     */
    public function etablissements(): BelongsToMany
    {
        return $this->belongsToMany(Etablissement::class)
                    ->withTimestamps()
                    ->withPivot('created_at', 'updated_at');
    }
    
    /**
     * Relation avec les établissements actifs seulement
     */
    public function activeEtablissements(): BelongsToMany
    {
        return $this->belongsToMany(Etablissement::class)
                    ->where('etablissements.is_active', true)
                    ->withTimestamps();
    }
    
    /**
     * Scope pour les activités actives
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    /**
     * Scope pour les activités inactives
     */
    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }
    
    /**
     * Compter le nombre d'établissements pour cette activité
     */
    public function etablissementsCount()
    {
        return $this->etablissements()->count();
    }
}