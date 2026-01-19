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
}