<?php

namespace App\Module\User\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserAPILoginFormRequest extends FormRequest
{

    public function rules()
    {
        return [
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
            'firebase_token' => ['nullable', 'string'],
            'platform' => ['required', 'string', 'max:255'],
        ];
    }
}
