<?php

namespace App\Http\Requests\Web\Zone;

use App\Http\Requests\FormRequest;

class CreateZoneRequest extends FormRequest
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
            'name'  => 'required|string|unique:zones,name',
            'mm_name'  => 'required|string|unique:zones,mm_name',
            'city_id'  => 'required|string|exists:cities,id',
            'is_available'  => 'nullable|boolean',
        ];
    }
}

