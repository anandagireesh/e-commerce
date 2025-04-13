<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->getRouteKey(),
            'items' => $this->resource->items,
            'total_price' => $this->resource->total_price,
            'shipping_cost' => $this->resource->shipping_cost,
            'discount' => $this->resource->discount,
            'grand_total' => $this->resource->grand_total,
            'payment_method' => $this->resource->payment_method,
            'payment_status' => $this->resource->payment_status,
        ];
    }
}
