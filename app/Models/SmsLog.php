<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SMSLog extends Model
{
    use HasFactory;

    protected $table = 'sms_logs';

    protected $fillable = ['farm_id', 'phone_number', 'message', 'status'];

    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }
}