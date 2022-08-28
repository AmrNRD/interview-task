<?php

namespace App\Module\Cart\Http\Requests\CartItem;
use App\Module\Cart\Http\Requests\CartItem\CartItemStoreFormRequest;

class CartItemUpdateFormRequest extends CartItemStoreFormRequest
{
    /**
     * Determine if the cartitem is authorized to make this request.
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
        // 'email'    => ['required','unique:cartitems,name,'.$this->route()->parameter('cartitem').',id'],
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
