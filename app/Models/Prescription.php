<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prescription extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'farm_id',
        'diagnosis',
        'medication',
        'dosage',
        'additional_notes',
        'status',
        'approved_by',
        'created_by',
    ];

    // Cast enum to string (optional)
    protected $casts = [
        'status' => 'string',
    ];

    // ✅ Relationships

    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

