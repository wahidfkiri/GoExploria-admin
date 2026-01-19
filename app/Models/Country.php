<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'iso2',
        'phone_code',
        'capital',
        'currency',
        'currency_symbol',
        'flag',
        'latitude',
        'longitude',
        'description',
        'population',
        'area',
        'official_language',
        'timezones',
        'region',
        'continent_id'
    ];

    protected $casts = [
        'timezones' => 'array',
        'population' => 'integer',
        'area' => 'decimal:2'
    ];

    // Relation avec le continent
    public function continent(): BelongsTo
    {
        return $this->belongsTo(Continent::class);
    }

    // Relation avec les villes (si vous en avez)
    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }

    // Accessor pour le nom complet avec code
    public function getFullNameAttribute(): string
    {
        return "{$this->name} ({$this->code})";
    }

    // Scope pour les pays par continent
    public function scopeByContinent($query, $continentCode)
    {
        return $query->whereHas('continent', function ($q) use ($continentCode) {
            $q->where('code', $continentCode);
        });
    }

    // Scope pour les pays d'une région spécifique
    public function scopeByRegion($query, $region)
    {
        return $query->where('region', $region);
    }

    public function provinces()
    {
        return $this->hasMany(Province::class);
    }

    
// Dans app/Models/Country.php, ajoutez:
public function villes(): HasMany
{
    return $this->hasMany(Ville::class);
}
}