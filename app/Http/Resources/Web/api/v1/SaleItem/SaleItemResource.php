<?php

namespace App\Http\Resources\Web\api\v1\SaleItem;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Web\api\v1\Product\ProductResource;

class SaleItemResource extends JsonResource
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
            'order_id' => $this->order_id,
            'product_id' => $this->product_id,
            'product_name' => $this->product_name,
            'product_item_code' => $this->product_item_code,
            'qty' => $this->qty,
            'price' => $this->price,
            'amount' => $this->amount,
            'discount_amount' => $this->discount_amount,
            'product' => ProductResource::make($this->whenLoaded('product')),
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
