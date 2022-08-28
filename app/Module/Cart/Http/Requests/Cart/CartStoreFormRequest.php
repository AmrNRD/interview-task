<?php

namespace App\Module\Cart\Http\Requests\Cart;

use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;

class CartStoreFormRequest extends FormRequest
{
    /**
     * Determine if the Cart is authorized to make this request.
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
            
			'user_id'  =>  'required|numeric|exists:users,id',
        ];
        return $rules;
    }


}
