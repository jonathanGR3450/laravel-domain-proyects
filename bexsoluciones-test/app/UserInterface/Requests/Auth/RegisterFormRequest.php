<?php

namespace App\UserInterface\Requests\Auth;

use App\UserInterface\Requests\CustomFormRequest;

class RegisterFormRequest extends CustomFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'email|required|unique:users,email,' . $this->id,
            'password' => 'nullable',
            'identification' => 'required|numeric',
            'is_verified' => 'nullable',
        ];
        if (!$this->id) {
            $rules['password'] = 'required|string|min:6|confirmed';
        }
        return $rules;
    }
}
