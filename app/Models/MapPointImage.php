<?php
// app/Models/MapPointImage.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MapPointImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'map_point_id',
        'image',
        'thumbnail',
        'caption',
        'sort_order',
        'is_main'
    ];

    protected $casts = [
        'is_main' => 'boolean',
        'sort_order' => 'integer'
    ];

    // Relations
    public function mapPoint()
    {
        return $this->belongsTo(MapPoint::class);
    }

    // Accesseurs — l'image vit chez l'admin (ou sur le CDN) : adresse
    // complète telle quelle, ancien chemin relatif résolu contre l'admin.
    // (asset('storage/…') donnait une image cassée dans les deux cas.)
    public function getUrlAttribute()
    {
        return \App\Support\MediaAdmin::url($this->image);
    }

    public function getThumbUrlAttribute()
    {
        return $this->thumbnail
            ? \App\Support\MediaAdmin::url($this->thumbnail)
            : $this->url;
    }

    // Scope
    public function scopeMain($query)
    {
        return $query->where('is_main', true);
    }
}