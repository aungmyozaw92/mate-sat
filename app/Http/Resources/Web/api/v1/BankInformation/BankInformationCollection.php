<?php

namespace App\Http\Resources\Web\api\v1\BankInformation;

use App\Http\Resources\Web\api\v1\BankInformation\BankInformationResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BankInformationCollection extends ResourceCollection
{

    /**
     * The resource that this resource collects.
     *
     * @var string
     */
    public $collects = BankInformationResource::class;

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
        ];
    }
}
