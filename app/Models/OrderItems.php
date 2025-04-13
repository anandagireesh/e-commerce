<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    protected $table = 'order_items';

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
        'vat',
        'total_price',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
