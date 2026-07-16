<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Contenu de page d'un Service (côté FRONT) — table partagée
 * `service_page_contents`. Types : about, event, blog, video, gallery,
 * testimonial, faq, contact. Rendu dans la landing de détail du service.
 */
class ServicePageContent extends Model
{
    use SoftDeletes;

    protected $table = 'service_page_contents';

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
        'published_at' => 'datetime',
        'order' => 'integer',
        'duration' => 'integer',
        'event_start_date' => 'datetime',
        'event_end_date' => 'datetime',
        'event_capacity' => 'integer',
        'event_price' => 'decimal:2',
        'event_is_free' => 'boolean',
        'testimonial_rating' => 'integer',
        'video_muted' => 'boolean',
        'extra_data' => 'array',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function getImageUrlAttribute(): ?string
    {
        return Service::resolveMediaUrl($this->image);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }
}
