<?php

namespace App\Module\User\Http\Requests\UserDevice;
use App\Module\User\Http\Requests\UserDevice\UserDeviceStoreFormRequest;

class UserDeviceUpdateFormRequest extends UserDeviceStoreFormRequest
{
    /**
     * Determine if the userdevice is authorized to make this request.
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
        // 'email'    => ['required','unique:userdevices,name,'.$this->route()->parameter('userdevice').',id'],
        ];

        return array_merge(parent::rules(), $rules);
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return parent::attributes();
    }
}
