<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceRecord extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'farm_id',
        'service_category_id',
        'species_number_flock',
        'species_number_infected',
        'species_number_dead',
        'species_type_species',
        'species_type_breed',
        'species_type_gender',
        'species_type_age',
        'history_of_disease',
        'microscopic_result',
        'disease_id',
        'prescription_id',
        'created_by',
    ];

    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }

    public function serviceCategory()
    {
        return $this->belongsTo(ServiceCategory::class);
    }

    public function disease()
    {
        return $this->belongsTo(Disease::class);
    }

    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}