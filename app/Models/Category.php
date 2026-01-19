<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active',
    ];

    public function websites()
    {
        return $this->hasMany(Website::class, 'categorie_id');
    }

    public function templates()
    {
        return $this->hasMany(Template::class, 'categorie_id');
    }

     public function activities()
    {
        return $this->hasMany(Activity::class);
    }
}
