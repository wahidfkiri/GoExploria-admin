<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Regroupement (titre + ancre) de la page publique /welcome, géré depuis
 * l'admin (Constructeur /welcome). Partage la table `welcome_zones` de la
 * base demo_laravel avec l'admin.
 */
class WelcomeZone extends Model
{
    protected $table = 'welcome_zones';

    protected $fillable = ['key', 'title', 'anchor', 'icon', 'order', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
        'order'     => 'integer',
    ];

    public function sections(): HasMany
    {
        return $this->hasMany(WelcomeSection::class, 'zone_id')->orderBy('order');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('id');
    }
}
