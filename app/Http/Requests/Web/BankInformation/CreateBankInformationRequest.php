<?php

namespace App\Http\Requests\Web\BankInformation;

use App\Http\Requests\FormRequest;

class CreateBankInformationRequest extends FormRequest
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
            'account_name'  => 'required|string',
            'bank_id'  => 'required|string|exists:banks,id',
            'account_no'  => 'required|numeric',
            'resourceable_type'  => 'required|string|in:Agent',
            'resourceable_id'  => 'required|string',

        ];
    }
}

