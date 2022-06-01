<?php

namespace App\Http\Resources\Web\api\v1\DailySale;

use Illuminate\Http\Resources\Json\JsonResource;

class DailySaleResource extends JsonResource
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
            'order_id' => $this->order_id,
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
            'status' => $this->status,
            'payment_status' => $this->payment_status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'cash_amount' => $this->cash_amount,
            'kbz_amount' => $this->kbz_amount,
            'kpay_amount' => $this->kpay_amount,
            'cb_pay_amount' => $this->cb_pay_amount,
            'cb_amount' => $this->cb_amount,
            'aya_pay_amount' => $this->aya_pay_amount,
            'aya_amount' => $this->aya_amount,
            'wave_pay_amount' => $this->wave_pay_amount,
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
