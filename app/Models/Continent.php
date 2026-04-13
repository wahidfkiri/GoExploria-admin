<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use App\Traits\HasPage;

class Continent extends Model
{
    use HasFactory, SoftDeletes, HasPage;

    protected $appends = ['image_url'];

    protected $fillable = [
        'name',
        'code',
        'image',
        'description',
        'population',
        'area',
        'countries_count',
        'languages',
        'is_active'
    ];

    protected $casts = [
        'languages' => 'array',
        'population' => 'integer',
        'area' => 'decimal:2',
        'countries_count' => 'integer',
        'is_active' => 'boolean'
    ];

    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) return null;
        return Storage::disk('public')->url($this->image);
    }

    // Relation avec les pays
    public function countries()
    {
        return $this->hasMany(Country::class);
    }


    public function activities()
    {
        return $this->belongsToMany(Activity::class, 'activity_continent')
                    ->withTimestamps();
    }

    

    public function scopeActive($query)
{
    return $query->where('is_active', true);
}

    // Méthode pour mettre à jour le nombre de pays automatiquement
    public function updateCountriesCount(): void
    {
        $this->update([
            'countries_count' => $this->countries()->count()
        ]);
    }

    // Accessor pour le nombre de pays formaté
    public function getFormattedCountriesCountAttribute(): string
    {
        return number_format($this->countries_count ?? 0);
    }
}