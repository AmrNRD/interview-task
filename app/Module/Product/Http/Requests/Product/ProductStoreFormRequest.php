<?php

namespace App\Module\Product\Http\Requests\Product;

use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;

class ProductStoreFormRequest extends FormRequest
{
    /**
     * Determine if the Product is authorized to make this request.
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

			'name'  =>  'required|array',
			'store_id'  =>  'required|numeric|exists:stores,id',
			'price'  =>  'required|numeric',
			'vat_included'  =>  'required|boolean',
        ];
        return $rules;
    }


}
