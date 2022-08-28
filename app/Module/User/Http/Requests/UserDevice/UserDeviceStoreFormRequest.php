<?php

namespace App\Module\User\Http\Requests\UserDevice;

use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;

class UserDeviceStoreFormRequest extends FormRequest
{
    /**
     * Determine if the UserDevice is authorized to make this request.
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
        $rules = [
            
			'fcm_token'  =>  'required|string|max:255',
			'type'  =>  'required|string|in:ios,android,web',
			'user_id'  =>  'required|string|exists:users,id|max:255',
        ];
        return $rules;
    }


}
