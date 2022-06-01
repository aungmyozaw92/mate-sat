<?php

namespace App\Http\Resources\Web\api\v1\Order;

use App\Http\Resources\Web\api\v1\Customer\CustomerResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Web\api\v1\OrderItem\OrderItemCollection;

class OrderResource extends JsonResource
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
            'order_no' => $this->order_no,
            'customer_id' => $this->customer_id,
            'customer_name' => $this->customer_name,
            'customer_phone' => $this->customer_phone,
            'customer_address' => $this->customer_address,
            'customer_city_name' => $this->customer_city_name,
            'customer_zone_name' => $this->customer_zone_name,
            'total_qty' => $this->total_qty,
            'total_price' => $this->total_price,
            'total_amount' => $this->total_amount,
            'total_product_discount' => $this->total_product_discount,
            'total_overall_discount' => $this->total_overall_discount,
            'grand_total_amount' => $this->grand_total_amount,
            'status' => $this->status,
            'type' => $this->type,
            'delivery_address' => $this->delivery_address,
            'order_items' => OrderItemCollection::make($this->whenLoaded('order_items')),
            'customer' => CustomerResource::make($this->whenLoaded('customer')),
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
