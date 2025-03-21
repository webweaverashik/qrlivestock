<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SMSLog extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['farm_id', 'phone_number', 'message', 'status'];

    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }
}