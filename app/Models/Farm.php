<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Farm extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'farm_name',
        'owner_name',
        'phone_number',
        'union_id',
        'address',
        'unique_id',
        'status',
        'is_active',
        'photo_url',
        'qr_code',
        'created_by',
        'approved_by',
        'approved_at',
        'remarks'
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function union()
    {
        return $this->belongsTo(Union::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function livestockCounts()
    {
        return $this->hasMany(LivestockCount::class);
    }

    public function serviceRecords()
    {
        return $this->hasMany(ServiceRecord::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }
}

