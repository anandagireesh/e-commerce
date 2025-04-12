<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\Category\CategoryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'name' => $this->resource->name,
            'description' => $this->resource->description,
            'price' => $this->resource->price,
            'stock' => $this->resource->stock,
            'images' => ProductImageResource::collection($this->resource->images),
            'categories' => CategoryResource::collection($this->resource->categories),
        ];
    }
}

class ProductImageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->getRouteKey(),
            'image' => $this->resource->image,
            'is_primary' => $this->resource->is_primary,
        ];
    }
}
