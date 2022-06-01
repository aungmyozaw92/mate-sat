<?php

namespace App\Http\Requests\Web\City;

use App\Http\Requests\FormRequest;

class CreateCityRequest extends FormRequest
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
            'name'  => 'required|string|unique:cities,name',
            'mm_name'  => 'required|string|unique:cities,mm_name',
            'is_available'  => 'nullable|boolean',
        ];
    }
}

