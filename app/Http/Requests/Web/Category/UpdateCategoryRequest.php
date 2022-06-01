<?php

namespace App\Http\Requests\Web\Category;

use App\Http\Requests\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:categories,name,'.$this->route('category')->id,
            'mm_name' => 'nullable|string|max:255|unique:categories,mm_name,'.$this->route('category')->id,
        ];
    }
}
