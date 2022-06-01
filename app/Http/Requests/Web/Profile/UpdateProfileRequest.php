<?php

namespace App\Http\Requests\Web\Profile;

use App\User;
use App\Http\Requests\FormRequest;
use Illuminate\Support\Facades\Hash;

class UpdateProfileRequest extends FormRequest
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
            'name'               => 'nullable|string|max:255',
            'email'              => 'nullable|email|unique:users,email',
            'phone'              => 'nullable|numeric|unique:users,phone',
            'address'            => 'nullable|string',
            'old_password'       => 'required_with:new_password|string|min:6',
            'new_password'       => 'nullable|confirmed|string|min:6',
        ];
    }

    /**
    * Configure the validator instance.
    *
    * @param  \Illuminate\Validation\Validator  $validator
    * @return void
    */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->has('old_password') && !Hash::check($this->old_password, \Auth::user()->password)) {
                $validator->errors()->add('old_password', 'Old password not valid');
            }
        });
    }

    public function updateProfile($user) : User
    {
        $user->name = $this->name ? $this->name : $user->name;
        $user->email = $this->email ? $this->email : $user->email;
        $user->phone = $this->phone ? $this->phone : $user->phone;
        $user->address = $this->address ? $this->address : $user->address;
        $user->password = $this->new_password ? bcrypt($this->new_password) : $user->password;

        if($user->isDirty()) {
            $user->updated_by = $user->id;
            $user->save();
        }

        return $user->refresh();
    }
}
