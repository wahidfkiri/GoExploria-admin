<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'product_categories';

    protected $fillable = [
        'etablissement_id',
        'name',
        'slug',
        'description',
        'parent_id',
        'product_family_id',
        'categorie_type_id',
        'image',
        'order',
        'is_active',
        'metadata'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'metadata' => 'array'
    ];

    public function etablissement()
    {
        return $this->belongsTo(Etablissement::class);
    }

    /**
     * Rayons visibles par un établissement : les siens ET ceux de la
     * plateforme (etablissement_id null), qui restent partagés par tous.
     */
    public function scopePourEtablissement($query, $etablissementId)
    {
        return $query->where(function ($q) use ($etablissementId) {
            $q->where('etablissement_id', $etablissementId)
                ->orWhereNull('etablissement_id');
        });
    }

    public function parent()
    {
        return $this->belongsTo(ProductCategory::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(ProductCategory::class, 'parent_id');
    }

    public function family()
    {
        return $this->belongsTo(ProductFamily::class, 'product_family_id');
    }

    public function categorieType()
    {
        return $this->belongsTo(CategorieType::class, 'categorie_type_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'product_category_id');
    }

    public function getFullPathAttribute()
    {
        $category = $this;
        $path = collect([$category->name]);
        
        while ($category->parent) {
            $category = $category->parent;
            $path->prepend($category->name);
        }
        
        return $path->join(' > ');
    }
}