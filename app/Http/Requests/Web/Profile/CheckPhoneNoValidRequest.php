<?php

namespace App\Http\Requests\Web\Profile;

use App\Http\Requests\FormRequest;
class CheckPhoneNoValidRequest extends FormRequest
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
            'phone_no'  => 'required|numeric|phone:MM'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    // public function attributes()
    // {
    //     return [
    //         'phone_no.required' => 'phone number is invalid',
    //     ];
    // }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
// use trans instead on Lang 
        return [
             'phone_no.required' => 'phone number is invalid',
        ];
    }
    

}
