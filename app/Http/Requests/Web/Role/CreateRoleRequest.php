<?php

namespace App\Http\Requests\Web\Role;

use App\Http\Requests\FormRequest;

class CreateRoleRequest extends FormRequest
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
            'name' => 'required|unique:roles,name',
            // 'permission' => 'required|array',
            // 'permission.*' => 'integer|exists:permissions,id',
        ];
    }
}
