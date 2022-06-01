<?php

namespace App\Http\Resources\Web\api\v1\Zone;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Web\api\v1\City\CityResource;
use App\Http\Resources\Web\api\v1\Region\RegionResource;
use App\Http\Resources\Web\api\v1\District\DistrictResource;
use App\Http\Resources\Web\api\v1\Township\TownshipResource;

class ZoneResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        // $total_balance += $this->balance;
        return [
            'id' => $this->id,
            'name' => $this->name,
            'mm_name' => $this->mm_name,
            'is_available' => $this->is_available,
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
