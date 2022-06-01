<?php

namespace App\Http\Requests\Web\Order;

use App\Http\Requests\FormRequest;

class CreateOrderRequest extends FormRequest
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
            'customer_id'  => 'required|string|exists:customers,id',
            'total_overall_discount'  => 'nullable|regex:/^\d{1,14}(\.\d{1,2})?$/',

            'order_items'  => 'required|array',
            'order_items.*.product_id'  =>  'required|string|exists:products,id',
            'order_items.*.product_name'     =>  'required|string',
            'order_items.*.product_item_code'   =>  'required|string',
            'order_items.*.qty'     =>  'required|regex:/^\d{1,14}(\.\d{1,2})?$/',
            'order_items.*.price'     =>  'required|regex:/^\d{1,14}(\.\d{1,2})?$/',
            'order_items.*.discount_amount'     => 'nullable|regex:/^\d{1,14}(\.\d{1,2})?$/',
            'delivery_address' => 'nullable|string'
        ];
    }
}
