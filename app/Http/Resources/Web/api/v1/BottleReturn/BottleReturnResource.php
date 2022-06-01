<?php

namespace App\Http\Resources\Web\api\v1\BottleReturn;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Web\api\v1\Sale\SaleResource;
use App\Http\Resources\Web\api\v1\User\UserResource;
use App\Http\Resources\Web\api\v1\Product\ProductResource;
use App\Http\Resources\Web\api\v1\Customer\CustomerResource;
use App\Http\Resources\Web\api\v1\BottleReturnHistory\BottleReturnHistoryCollection;

class BottleReturnResource extends JsonResource
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
            'sale_id' => $this->sale_id,
            'sale_item_id' => $this->sale_item_id,
            'product_id' => $this->product_id,
            'customer_id' => $this->customer_id,
            'total_bottle' => $this->total_bottle,
            'remain_bottle' => $this->remain_bottle,
            'status' => $this->status,
            'created_by' => $this->relationLoaded('created_user') ? UserResource::make($this->whenLoaded('created_user'))->only(['id','name']) : null,
            'sale' =>  $this->relationLoaded('sale') ?  SaleResource::make($this->whenLoaded('sale'))->only(['id','invoice_no']) : null,
            'product' => $this->relationLoaded('product') ?  ProductResource::make($this->whenLoaded('product'))->only(['id','name']) : null,
            'customer' => $this->relationLoaded('customer') ?  CustomerResource::make($this->whenLoaded('customer'))->only(['id','name']) : null,
            'bottle_return_histories' => BottleReturnHistoryCollection::make($this->whenLoaded('bottle_return_histories')),
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
