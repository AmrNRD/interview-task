<?php

namespace App\Module\Store\Http\Requests\Store;

use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;

class ChangeStoreStateFormRequest extends FormRequest
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
            'state'        => ['required', 'string', 'in:active,inactive'],
        ];
        return $rules;
    }


}
