<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kayandra\Hashidable\Hashidable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory, Hashidable;
    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'total_price',
        'shipping_cost',
        'discount',
        'grand_total',
        'payment_method',
        'payment_status',
        'order_status',
        'order_date',
        'order_address',
    ];

    public function items()
    {
        return $this->hasMany(OrderItems::class);
    }
}
