<?php

namespace App\Http\Resources\Web\api\v1\SalePayment;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Web\api\v1\User\UserResource;
use App\Http\Resources\Web\api\v1\Customer\CustomerResource;

class SalePaymentResource extends JsonResource
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
            'payment_method' => $this->payment_method,
            'payment_amount' => $this->payment_amount,
            'payment_reference' => $this->payment_reference,
            // 'payment_status' => $this->payment_status,
            'note' => $this->note,
            'created_at' => date('Y-m-d', strtotime($this->created_at)),
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
