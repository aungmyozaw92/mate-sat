<?php

namespace App\Http\Requests\Web\Category;

use App\Http\Requests\FormRequest;

class CreateCategoryRequest extends FormRequest
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
            'name'  => 'required|string|unique:categories,name',
            'mm_name'  => 'nullable|string|unique:categories,mm_name',
        ];
    }
}

