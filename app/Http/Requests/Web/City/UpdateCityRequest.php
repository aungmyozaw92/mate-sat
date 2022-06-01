<?php

namespace App\Http\Requests\Web\City;

use App\Http\Requests\FormRequest;

class UpdateCityRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:cities,name,'.$this->route('city')->id,
            'mm_name' => 'required|string|max:255|unique:cities,mm_name,'.$this->route('city')->id,
            'is_available'  => 'nullable|boolean',
        ];
    }
}
