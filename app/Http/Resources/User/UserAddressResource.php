<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAddressResource extends JsonResource
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
            'address_line_1' => $this->resource->address_line_1,
            'address_line_2' => $this->resource->address_line_2,
            'city' => $this->resource->city,
            'state_id' => $this->resource->state_id,
            'state' => $this->resource->state->state,
            'country_id' => $this->resource->country_id,
            'country' => $this->resource->country->country,
            'zip_code' => $this->resource->zip_code,
            'is_default' => $this->resource->is_default,
        ];
    }
}
