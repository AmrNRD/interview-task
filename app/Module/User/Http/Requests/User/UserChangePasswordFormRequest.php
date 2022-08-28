<?php

namespace App\Module\User\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserChangePasswordFormRequest extends FormRequest
{
    /**
     * Determine if the LibraryPost is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    public function rules()
    {
        return [
            'old_password' => 'required|min:8|max:32',
            'password' => 'required|min:8|max:32|confirmed',
        ];
    }
}
