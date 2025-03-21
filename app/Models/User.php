<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
        'photo_url'
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
            'is_active' => 'boolean',
        ];
    }

    // Get all the farms created by this user
    public function farmsCreated()
    {
        return $this->hasMany(Farm::class, 'created_by');
    }

    // Get all the farms approved by this user
    public function farmsApproved()
    {
        return $this->hasMany(Farm::class, 'approved_by');
    }

    // Get all the services record entered by this user
    public function serviceRecords()
    {
        return $this->hasMany(ServiceRecord::class, 'created_by');
    }

    // Get all the prescriptions entered by this user
    public function prescriptionsCreated()
    {
        return $this->hasMany(Prescription::class, 'created_by');
    }

    // Get all the prescriptions approved by this user
    public function prescriptionsApproved()
    {
        return $this->hasMany(Prescription::class, 'approved_by');
    }
}
