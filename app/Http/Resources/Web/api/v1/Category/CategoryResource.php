<?php

namespace App\Http\Resources\Web\api\v1\Category;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Web\api\v1\Product\ProductCollection;

class CategoryResource extends JsonResource
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
            'products' => ProductCollection::make($this->whenLoaded('products')),
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
