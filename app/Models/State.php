<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table = 'states';
    protected $fillable = [
        'country_id',
        'country_code',
        'iso2',
        'state',
        'latitude',
        'longitude',
        'language',
    ];
}
