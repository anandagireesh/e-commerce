<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ProductImages;
use App\Models\ProductStock;
use Kayandra\Hashidable\Hashidable;

class Product extends Model
{
    use SoftDeletes, Hashidable;

    protected $table = 'products';
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
    ];

    public function images()
    {
        return $this->hasMany(ProductImages::class);
    }

    public function stocks()
    {
        return $this->hasMany(ProductStock::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
