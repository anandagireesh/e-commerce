<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'addresses';
    protected $fillable = [
        'address_line_1',
        'address_line_2',
        'city',
        'state_id',
        'country_id',
        'zip_code',
        'user_id',
        'is_default',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
