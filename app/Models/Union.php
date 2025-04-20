<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Union extends Model
{
    protected $table = 'unions';

    protected $fillable = [
        'name',
    ];

    public function farms()
    {
        return $this->hasMany(Farm::class);
    }
}
