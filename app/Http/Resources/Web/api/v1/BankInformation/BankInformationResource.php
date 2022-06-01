<?php

namespace App\Http\Resources\Web\api\v1\BankInformation;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Web\api\v1\Bank\BankResource;

class BankInformationResource extends JsonResource
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
            'account_name' => $this->account_name,
            'account_no' => $this->account_no,
            'bank_branch_name' => $this->bank_branch_name,
            
            'bank' => BankResource::make($this->whenLoaded('bank')),
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
