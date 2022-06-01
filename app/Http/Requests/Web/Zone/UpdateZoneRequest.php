<?php

namespace App\Http\Requests\Web\Zone;

use App\Http\Requests\FormRequest;

class UpdateZoneRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:zones,name,'.$this->route('zone')->id,
            'mm_name' => 'required|string|max:255|unique:zones,mm_name,'.$this->route('zone')->id,
            'city_id'  => 'required|string|exists:cities,id',
            'is_available'  => 'nullable|boolean',
        ];
    }
}
