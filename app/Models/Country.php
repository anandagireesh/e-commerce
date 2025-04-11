<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'countries';
    protected $fillable = [
        'country',
        'iso2',
        'iso3',
        'phone_code',
        'capital',
        'currency',
        'native',
        'emoji',
        'language',
        'currency_name',
        'currency_symbol',
        'region',
        'subregion',
        'nationality',
        'time_zone_name',
        'gmt_offset',
        'gmt_offset_name',
        'abbreviation',
        'tz_name',
        'emojiU',
        'latitude',
        'longitude',
    ];
}
