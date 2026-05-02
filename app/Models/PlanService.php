<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PlanService extends Model
{
    use HasFactory;

    private const ADMIN_STORAGE_BASE_URL = 'https://admin.goexploriabusiness.com/storage';

    protected $table = 'plan_services';

    protected $fillable = [
        'plan_id',
        'title',
        'slug',
        'description',
        'content',
        'service_type',
        'price',
        'currency',
        'is_active',
        'sort_order',
        'main_media_type',
        'main_image_path',
        'main_video_path',
        'main_video_url',
        'gallery',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'gallery' => 'array',
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Full URL for main image media.
     */
    public function getMainImageUrlAttribute(): ?string
    {
        return $this->buildMediaUrl($this->main_image_path);
    }

    /**
     * Full URL for main video media.
     */
    public function getMainVideoUrlAttribute(): ?string
    {
        if (!empty($this->main_video_url) && is_string($this->main_video_url)) {
            return trim($this->main_video_url);
        }

        return $this->buildMediaUrl($this->main_video_path);
    }

    /**
     * Full URLs for gallery images.
     */
    public function getGalleryImageUrlsAttribute(): array
    {
        $gallery = $this->gallery;
        if (!is_array($gallery)) {
            return [];
        }

        return collect($gallery)
            ->filter(fn ($path) => is_string($path) && trim($path) !== '')
            ->map(fn ($path) => $this->buildMediaUrl($path))
            ->filter()
            ->values()
            ->all();
    }

    /**
     * Build full media URL from DB path.
     */
    private function buildMediaUrl(?string $path): ?string
    {
        if (!is_string($path) || trim($path) === '') {
            return null;
        }

        $path = trim($path);
        if (Str::startsWith($path, ['http://', 'https://', '//', 'data:'])) {
            return $path;
        }

        $cleanPath = ltrim($path, '/');
        if (Str::startsWith($cleanPath, 'storage/')) {
            $cleanPath = Str::after($cleanPath, 'storage/');
        }
        if (Str::startsWith($cleanPath, 'public/')) {
            $cleanPath = Str::after($cleanPath, 'public/');
        }

        return rtrim(self::ADMIN_STORAGE_BASE_URL, '/') . '/' . ltrim($cleanPath, '/');
    }
}
