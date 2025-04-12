<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->getRouteKey(),
            'first_name' => $this->resource->first_name,
            'last_name' => $this->resource->last_name,
            'email' => $this->resource->email,
            'phone' => $this->resource->phone,
            'profile_pic' => $this->resource->profile_pic,
            'addresses' => UserAddressResource::collection($this->resource->address),
            'token' => $this->resource->token,
        ];
    }

    public static function collection($resource)
    {
        $pagination = [];

        if (method_exists($resource, 'total')) {
            $pagination = [
                'meta' => [
                    'total' => $resource->total(),
                    'per_page' => $resource->perPage(),
                    'current_page' => $resource->currentPage(),
                    'last_page' => $resource->lastPage(),
                    'from' => $resource->firstItem(),
                    'to' => $resource->lastItem(),
                ],
            ];
        }

        return parent::collection($resource)->additional($pagination);
    }
}
