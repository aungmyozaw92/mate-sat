<?php

namespace App\Http\Resources\Web\api\v1\BottleReturnHistory;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Web\api\v1\User\UserResource;

class BottleReturnHistoryResource extends JsonResource
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
            'bottle_return_id' => $this->bottle_return_id,
            'returned_bottle' => $this->returned_bottle,
            'returned_date' => $this->returned_date,
            'created_by' => $this->relationLoaded('created_user') ? UserResource::make($this->whenLoaded('created_user'))->only(['id','name']) : null,
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
