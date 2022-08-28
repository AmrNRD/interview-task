<?php

namespace App\Module\Cart\Http\Requests\Cart;
use App\Module\Cart\Http\Requests\Cart\CartStoreFormRequest;

class CartUpdateFormRequest extends CartStoreFormRequest
{
    /**
     * Determine if the cart is authorized to make this request.
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
        // 'email'    => ['required','unique:carts,name,'.$this->route()->parameter('cart').',id'],
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
