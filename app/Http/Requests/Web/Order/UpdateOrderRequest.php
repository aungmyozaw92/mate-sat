<?php

namespace App\Http\Requests\Web\Order;

use App\Http\Requests\FormRequest;

class UpdateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'customer_id'  => 'nullable|string|exists:customers,id',
            'total_overall_discount'  => 'nullable|regex:/^\d{1,14}(\.\d{1,2})?$/',
            'delivery_address' => 'nullable|string'
        ];
    }
}
