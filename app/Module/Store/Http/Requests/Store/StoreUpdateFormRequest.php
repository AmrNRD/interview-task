<?php

namespace App\Module\Store\Http\Requests\Store;
use App\Module\Store\Http\Requests\Store\StoreStoreFormRequest;

class StoreUpdateFormRequest extends StoreStoreFormRequest
{
    /**
     * Determine if the store is authorized to make this request.
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
        // 'email'    => ['required','unique:stores,name,'.$this->route()->parameter('store').',id'],
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
