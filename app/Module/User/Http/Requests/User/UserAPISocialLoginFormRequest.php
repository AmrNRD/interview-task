<?php

namespace App\Module\User\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserAPISocialLoginFormRequest extends FormRequest
{

    public function rules()
    {
        return [
            'name' => ['nullable', 'string', 'max:255'],
            'user_id' => ['required', 'string', 'max:255'],
            'provider_type' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'firebase_token' => ['nullable', 'string'],
            'platform' => ['required', 'string', 'max:255'],
            'profile_url' => ['nullable', 'string', 'max:255'],
        ];

    }
}
