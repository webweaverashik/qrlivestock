<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prescription extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'livestock_type_id',
        'livestock_age',
        'livestock_weight',
        'disease_brief',
        'medication',
        'livestock_temp',
        'livestock_pulse',
        'livestock_rumen_motility',
        'livestock_respiratory',
        'livestock_other',
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
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function livestockType()
    {
        return $this->belongsTo(LivestockType::class, 'livestock_type_id');
    }

    public function serviceRecord()
    {
        return $this->hasOne(ServiceRecord::class, 'prescription_id');
    }

}
