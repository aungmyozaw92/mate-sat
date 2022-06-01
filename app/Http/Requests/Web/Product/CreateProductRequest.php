<?php

namespace App\Http\Requests\Web\Product;

use App\Http\Requests\FormRequest;

class CreateProductRequest extends FormRequest
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
            'name'  => 'required|string|unique:products,name',
            'mm_name'  => 'nullable|string|unique:products,mm_name',
            'item_code'  => 'required|string|unique:products,item_code',
            'category_id'  => 'required|string|exists:categories,id',
            'price'  => 'required|regex:/^\d{1,14}(\.\d{1,2})?$/',
            'description'  => 'nullable|string',
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_available'  => 'nullable|boolean',
            'exclusive_bottle'  => 'nullable|boolean',
        ];
    }
}
