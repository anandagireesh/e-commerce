<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kayandra\Hashidable\Hashidable;

class Category extends Model
{
    use Hashidable, SoftDeletes;
    protected $table = 'categories';

    protected $fillable = [
        'name',
        'slug'
    ];
}
