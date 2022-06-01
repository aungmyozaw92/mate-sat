<?php

namespace App\Http\Requests\Web\User;

use App\Http\Requests\FormRequest;

class CreateUserRequest extends FormRequest
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
            'name'      => 'required|string|max:255',
            'username'  => 'required|string|unique:users,username',
            'email'     => 'required|email|unique:users,email',
            'phone'     => 'nullable|numeric|unique:users,phone',
            'address'   => 'nullable|string',
            'password'  => 'required|string|min:6|confirmed|regex:/^(?=.*?[a-z])(?=.*?[0-9]).{6,}$/',
            'roles'     => 'required',
            'is_approved' => 'nullable|boolean',
            'department_id' => 'required|string|exists:departments,id',
            'branch_id' => 'nullable|string|exists:branches,id',
        ];
    }
}
