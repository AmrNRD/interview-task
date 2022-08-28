<?php

namespace App\Module\Cart\Http\Requests\CartItem;

use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;

class CartItemStoreFormRequest extends FormRequest
{
    /**
     * Determine if the CartItem is authorized to make this request.
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
            
			'cart_id'  =>  'required|numeric|exists:carts,id',
			'product_id'  =>  'required|numeric|exists:products,id',
        ];
        return $rules;
    }


}
