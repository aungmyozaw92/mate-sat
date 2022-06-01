<?php

namespace App\Http\Requests\Web\OrderItem;

use App\Http\Requests\FormRequest;

class UpdateOrderItemRequest extends FormRequest
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
            'product_id'  =>  'required|string|exists:products,id',
            'product_name'  =>  'required|string',
            'product_item_code'  =>  'required|string',
            'qty'  =>  'required|regex:/^\d{1,14}(\.\d{1,2})?$/',
            'price'  =>  'required|regex:/^\d{1,14}(\.\d{1,2})?$/',
            'discount_amount'  => 'nullable|regex:/^\d{1,14}(\.\d{1,2})?$/',
        ];
    }
}
