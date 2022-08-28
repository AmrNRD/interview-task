<?php

namespace App\Module\User\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserForgetPasswordFormRequest extends FormRequest
{
    /**
     * Determine if the LibraryPost is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|max:255|email|exists:users,email',
        ];
    }
}
