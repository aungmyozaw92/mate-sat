<?php

namespace App\Http\Resources\Web\api\v1\Customer;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Web\api\v1\City\CityResource;
use App\Http\Resources\Web\api\v1\Zone\ZoneResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'customer_no' => $this->customer_no,
            'membership_no' => $this->membership_no,
            'name' => $this->name,
            'phone' => $this->phone,
            'another_phone' => $this->another_phone,
            'email' => $this->email,
            'address' => $this->address,
            'is_active' => $this->is_active,
            'sale_count' => $this->sale_count,
            'order_count' => $this->order_count,
            'zone' => ZoneResource::make($this->whenLoaded('zone')),
            'city' => CityResource::make($this->whenLoaded('city')),
        ];
    }
    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function with($request)
    {
        return [
            'status' => 1,
        ];
    }
}
