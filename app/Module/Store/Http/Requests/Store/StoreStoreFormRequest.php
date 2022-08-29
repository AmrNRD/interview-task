<?php

namespace App\Module\Store\Http\Requests\Store;

use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreStoreFormRequest extends FormRequest
{
    /**
     * Determine if the Store is authorized to make this request.
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

			'name'  =>  'required|string|max:255',
			'user_id'  =>  'required|numeric|exists:users,id',
			'shipping_cost'  =>  'nullable|numeric',
			'vat_percentage'  =>  'nullable|numeric',
        ];
        return $rules;
    }

    protected function defaults()
    {
        return [
            'user_id'  => Auth::id(),
        ];
    }

}
