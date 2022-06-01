<?php

namespace App\Http\Requests\Web\Customer;

use App\Http\Requests\FormRequest;

class CreateCustomerRequest extends FormRequest
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
            'membership_no'  => 'nullable|string|unique:customers,membership_no',
            'name'  => 'required|string|max:255',
            'email'  => 'nullable|string|unique:customers,email',
            'phone'  => 'required|numeric|phone:MM|unique:customers,phone',
            'another_phone'  => 'nullable|numeric|another_phone:MM',
            'city_id' => 'required|string|exists:cities,id',
            'zone_id' => 'required|string|exists:zones,id',
            'address' => 'required|string',
            'is_active' => 'nullable|boolean',
            'password'  => 'nullable|string|min:6|confirmed|regex:/^(?=.*?[a-z])(?=.*?[0-9]).{6,}$/'
        ];
    }
}