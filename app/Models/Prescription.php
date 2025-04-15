<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prescription extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'disease_brief',
        'medication',
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

    public function serviceRecord()
    {
        return $this->hasOne(ServiceRecord::class, 'prescription_id');
    }

}
