<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class DevisRequest extends Model
{
    protected $fillable = [
        'etablissement_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'company',
        'city',
        'country',
        'preferred_contact',
        'service_subject',
        'selected_services',
        'plan_interest',
        'budget',
        'project_deadline',
        'project_details',
        'media_files',
        'email_sent',
        'email_error',
        'client_ip',
        'user_agent',
        'source_url',
    ];

    protected $casts = [
        'selected_services' => 'array',
        'media_files' => 'array',
        'project_deadline' => 'date',
        'email_sent' => 'boolean',
    ];

    public function etablissement(): BelongsTo
    {
        return $this->belongsTo(Etablissement::class);
    }
}
