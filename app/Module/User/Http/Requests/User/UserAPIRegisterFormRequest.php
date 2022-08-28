<?php

namespace App\Module\User\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserAPIRegisterFormRequest extends FormRequest
{

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'max:255','confirmed'],
            'firebase_token' => ['nullable', 'string'],
            'platform' => ['required', 'string', 'max:255'],
        ];
    }
}
