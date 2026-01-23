<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

     protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Relation avec le profil client
     */
    public function customer()
    {
        return $this->hasOne(Customer::class);
    }

    
    public function etablissement()
    {
        return $this->hasOne(Etablissement::class);
    }

    /**
     * Relation avec les sites web
     */
    public function websites(): HasMany
    {
        return $this->hasMany(Website::class);
    }

    
   public function scopeActive($query)
{
    return $query->where('is_active', true);
}
}
