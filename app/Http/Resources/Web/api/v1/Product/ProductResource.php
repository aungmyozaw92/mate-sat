<?php

namespace App\Http\Resources\Web\api\v1\Product;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Web\api\v1\Category\CategoryResource;

class ProductResource extends JsonResource
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
            'name' => $this->name,
            'mm_name' => $this->mm_name,
            'item_code' => $this->item_code,
            'category_id' => $this->category_id,
            'price' => $this->price,
            'description' => $this->description,
            'is_available' => $this->is_available,
            'exclusive_bottle' => $this->exclusive_bottle,
            'image_path' => Storage::url($this->image_path),
            'category' => CategoryResource::make($this->whenLoaded('category')),
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
