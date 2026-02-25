<?php
// app/Models/Project.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'etablissement_id',
        'user_id',
        'client_id',
        'invoice_id',
        'contract_number',
        'contact_name',
        'start_date',
        'end_date',
        'status',
        'estimated_hours',
        'hourly_rate',
        'estimated_budget',
        'metadata',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'estimated_hours' => 'integer',
        'hourly_rate' => 'decimal:2',
        'estimated_budget' => 'decimal:2',
        'metadata' => 'json',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Relations
     */
    public function etablissement(): BelongsTo
    {
        return $this->belongsTo(Etablissement::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Etablissement::class, 'client_id');
    }


    // public function invoice(): BelongsTo
    // {
    //     return $this->belongsTo(Invoice::class);
    // }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    } 

    public function isOverdue(): bool
{
    if (!$this->end_date || in_array($this->status, ['completed', 'cancelled'])) {
        return false;
    }
    
    return $this->end_date->isPast();
}

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByEtablissement($query, $etablissementId)
    {
        return $query->where('etablissement_id', $etablissementId);
    }

    /**
     * Accesseurs
     */
    public function getProgressAttribute(): int
    {
        $totalTasks = $this->tasks()->count();
        if ($totalTasks === 0) {
            return 0;
        }
        
        $completedTasks = $this->tasks()->where('status', 'approved')->count();
        return round(($completedTasks / $totalTasks) * 100);
    }

    public function getFormattedStatusAttribute(): string
    {
        return match($this->status) {
            'planning' => 'Planification',
            'in_progress' => 'En cours',
            'on_hold' => 'En pause',
            'completed' => 'Terminé',
            'cancelled' => 'Annulé',
            default => $this->status,
        };
    }
}