<?php

namespace App\Http\Requests\Web\BottleReturn;

use App\Http\Requests\FormRequest;

class UpdateBottleReturnRequest extends FormRequest
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
            'returned_bottle'  => 'required|regex:/^\d{1,14}(\.\d{1,2})?$/',
        ];
    }
}
