<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Product;

class ProductImages extends Model
{
    use SoftDeletes;

    protected $table = 'product_images';
    protected $fillable = [
        'product_id',
        'image',
        'caption',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
