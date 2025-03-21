<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LivestockCount extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['farm_id', 'livestock_type_id', 'total'];

    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }

    public function livestockType()
    {
        return $this->belongsTo(LivestockType::class);
    }
}

