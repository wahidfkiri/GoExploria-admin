<?php
// app/Models/Task.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'details',
        'project_id',
        'etablissement_id',
        'user_id',
        'created_by',
        'country_id',
        'location',
        'invoice_id',
        'sales_plan_id',
        'contract_number',
        'contact_name',
        'due_date',
        'delivery_date',
        'estimated_hours',
        'hourly_rate',
        'estimated_cost',
        'status',
        'test_date',
        'test_details',
        'integration_date',
        'push_prod_date',
        'module_url',
        'is_approved_by_manager',
        'approved_by',
        'approved_at',
        'general_manager_id',
        'client_manager_id',
        'metadata',
        'is_active',
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'delivery_date' => 'datetime',
        'test_date' => 'datetime',
        'integration_date' => 'datetime',
        'push_prod_date' => 'datetime',
        'estimated_hours' => 'integer',
        'hourly_rate' => 'decimal:2',
        'estimated_cost' => 'decimal:2',
        'is_approved_by_manager' => 'boolean',
        'approved_at' => 'datetime',
        'metadata' => 'json',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Relations
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function etablissement(): BelongsTo
    {
        return $this->belongsTo(Etablissement::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class); // Si vous avez un modèle Country
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function salesPlan(): BelongsTo
    {
        return $this->belongsTo(SalesPlan::class);
    }

    public function generalManager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'general_manager_id');
    }

    public function clientManager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_manager_id');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(TaskComment::class);
    }

    public function locations(): BelongsToMany
    {
        return $this->belongsToMany(Location::class, 'task_locations')
                    ->withTimestamps();
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByEtablissement($query, $etablissementId)
    {
        return $query->where('etablissement_id', $etablissementId);
    }

    public function scopeByProject($query, $projectId)
    {
        return $query->where('project_id', $projectId);
    }

    public function scopeDueBetween($query, $startDate, $endDate)
    {
        return $query->whereBetween('due_date', [$startDate, $endDate]);
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved_by_manager', true);
    }

    /**
     * Accesseurs
     */
    public function getFormattedStatusAttribute(): string
    {
        return match($this->status) {
            'pending' => 'En attente',
            'in_progress' => 'En cours',
            'test' => 'En test',
            'integrated' => 'Intégré',
            'delivered' => 'Livré',
            'approved' => 'Approuvé',
            'cancelled' => 'Annulé',
            default => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'gray',
            'in_progress' => 'blue',
            'test' => 'yellow',
            'integrated' => 'purple',
            'delivered' => 'indigo',
            'approved' => 'green',
            'cancelled' => 'red',
            default => 'gray',
        };
    }

    public function getCalculatedCostAttribute(): float
    {
        if ($this->estimated_hours && $this->hourly_rate) {
            return $this->estimated_hours * $this->hourly_rate;
        }
        return $this->estimated_cost ?? 0;
    }

    /**
     * Mutateurs
     */
    public function setDueDateAttribute($value)
    {
        $this->attributes['due_date'] = $value ? Carbon::parse($value) : null;
    }

    public function setDeliveryDateAttribute($value)
    {
        $this->attributes['delivery_date'] = $value ? Carbon::parse($value) : null;
    }

    /**
     * Méthodes personnalisées
     */
    public function approve(int $userId): bool
    {
        return $this->update([
            'is_approved_by_manager' => true,
            'approved_by' => $userId,
            'approved_at' => now(),
            'status' => 'approved',
        ]);
    }

    public function isOverdue(): bool
    {
        return $this->due_date && $this->due_date->isPast() && !in_array($this->status, ['delivered', 'approved', 'cancelled']);
    }

    public function sendStatusNotification(): void
    {
        // Logique pour envoyer les emails automatiques
        // Vous pouvez utiliser les événements ou les notifications Laravel ici
    }
}