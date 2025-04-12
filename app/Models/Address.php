<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kayandra\Hashidable\Hashidable;

class Address extends Model
{
    use Hashidable;
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

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
