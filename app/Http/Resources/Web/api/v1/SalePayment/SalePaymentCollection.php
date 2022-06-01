<?php

namespace App\Http\Resources\Web\api\v1\SalePayment;

use App\Http\Resources\Web\api\v1\SalePayment\SalePaymentResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SalePaymentCollection extends ResourceCollection
{

    /**
     * The resource that this resource collects.
     *
     * @var string
     */
    public $collects = SalePaymentResource::class;

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
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
            //'total_balance' => $this->collection->sum('balance')
        ];
    }
}
