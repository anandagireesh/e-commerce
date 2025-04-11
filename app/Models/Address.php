<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table='addresses';
    protected $fillable=[
        'address_one',
        'address_two',
        'city',
        'state_id',
        'country_id',
    ];
}
