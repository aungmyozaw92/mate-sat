<?php

namespace App\Http\Resources\Web\api\v1\Sale;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Web\api\v1\User\UserResource;
use App\Http\Resources\Web\api\v1\Customer\CustomerResource;
use App\Http\Resources\Web\api\v1\SaleItem\SaleItemCollection;
use App\Http\Resources\Web\api\v1\SalePayment\SalePaymentCollection;

class SaleResource extends JsonResource
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
            'invoice_no' => $this->invoice_no,
            'customer_id' => $this->customer_id,
            'customer_name' => $this->customer_name,
            'customer_phone' => $this->customer_phone,
            'customer_address' => $this->customer_address,
            'customer_city_name' => $this->customer_city_name,
            'customer_zone_name' => $this->customer_zone_name,
            'total_qty' => $this->total_qty,
            'total_amount' => $this->total_amount,
            'total_discount' => $this->total_discount,
            'grand_total' => $this->grand_total,
            'paid_amount' => $this->paid_amount,
            'outstanding_amount' => $this->grand_total - $this->paid_amount,
            'status' => $this->status,
            'payment_status' => $this->payment_status,
            'delivery_address' => $this->delivery_address,
            'created_at' => date('Y-m-d', strtotime($this->created_at)),
            'sale_items' => SaleItemCollection::make($this->whenLoaded('sale_items')),
            'sale_payments' => SalePaymentCollection::make($this->whenLoaded('sale_payments')),
            'customer' => CustomerResource::make($this->whenLoaded('customer')),
            'created_user' => UserResource::make($this->whenLoaded('created_user')),
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
