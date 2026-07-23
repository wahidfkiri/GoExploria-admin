<?php
// app/Models/MapPoint.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MapPoint extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'category',
        'map_category_id',
        'type',
        'main_image',
        'youtube_url',
        'youtube_id',
        'latitude',
        'longitude',
        'adresse',
        'ville',
        'code_postal',
        'details_url',
        'has_details_page',
        'etablissement_id',
        'user_id',
        'is_active',
        'is_featured',
        'display_locations',
        'display_start_date',
        'display_end_date',
        'views'
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'has_details_page' => 'boolean',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'display_locations' => 'array',
        'display_start_date' => 'date',
        'display_end_date' => 'date',
        'views' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    /**
     * Emplacements d'affichage possibles d'un point map :
     * page d'accueil + pages de destination (continent → quartier).
     */
    public const DISPLAY_LOCATIONS = [
        'home' => 'Page accueil',
        'continent' => 'Pages Continent',
        'country' => 'Pages Pays',
        'province' => 'Pages Province',
        'region' => 'Pages Région',
        'secteur' => 'Pages Secteur',
        'ville' => 'Pages Ville',
        'arrondissement' => 'Pages Arrondissement',
        'quartier' => 'Pages Quartier',
    ];

    // Relations
    public function images()
    {
        return $this->hasMany(MapPointImage::class)->orderBy('sort_order');
    }

    public function mainImage()
    {
        return $this->hasOne(MapPointImage::class)->where('is_main', true);
    }

    public function videos()
    {
        return $this->hasMany(MapPointVideo::class)->orderBy('sort_order');
    }

    public function details()
    {
        return $this->hasOne(MapPointDetail::class);
    }

    public function etablissement()
    {
        return $this->belongsTo(Etablissement::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mapCategory()
    {
        return $this->belongsTo(MapCategory::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Points visibles sur un emplacement donné (home, continent, … quartier).
     * NULL ou liste vide = visible partout (rétro-compatibilité).
     */
    public function scopeVisibleOn($query, ?string $location)
    {
        if (!$location) {
            return $query;
        }

        // Alias : le type « city » (travel_destination) équivaut à « ville »
        if ($location === 'city') {
            $location = 'ville';
        }

        return $query->where(function ($q) use ($location) {
            $q->whereNull('display_locations')
              ->orWhereRaw("JSON_LENGTH(display_locations) = 0")
              ->orWhereJsonContains('display_locations', $location);
        });
    }

    /**
     * Points dans leur période d'affichage (bornes optionnelles).
     */
    public function scopeInDisplayPeriod($query)
    {
        $today = now()->toDateString();

        return $query
            ->where(function ($q) use ($today) {
                $q->whereNull('display_start_date')->orWhereDate('display_start_date', '<=', $today);
            })
            ->where(function ($q) use ($today) {
                $q->whereNull('display_end_date')->orWhereDate('display_end_date', '>=', $today);
            });
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeInBounds($query, $southWest, $northEast)
    {
        return $query->whereBetween('latitude', [$southWest['lat'], $northEast['lat']])
                     ->whereBetween('longitude', [$southWest['lng'], $northEast['lng']]);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->whereHas('mapCategory', function($q) use ($category) {
            $q->where('slug', $category);
        });
    }

    // Accesseurs
    public function getThumbnailAttribute()
    {
        if ($this->youtube_id) {
            return "https://img.youtube.com/vi/{$this->youtube_id}/hqdefault.jpg";
        }
        
        if ($this->main_image) {
            if (preg_match('/^https?:\/\//i', $this->main_image)) {
                return $this->main_image;
            }

            if (str_starts_with($this->main_image, '/storage/') || str_starts_with($this->main_image, 'storage/')) {
                return url('/' . ltrim($this->main_image, '/'));
            }

            return asset('storage/' . ltrim($this->main_image, '/'));
        }
        
        return asset('images/default-placeholder.jpg');
    }

    public function getPopupContentAttribute()
    {
        return view('components.map-popup', ['point' => $this])->render();
    }

    // Incrémenter les vues
    public function incrementViews()
    {
        $this->increment('views');
    }
}
