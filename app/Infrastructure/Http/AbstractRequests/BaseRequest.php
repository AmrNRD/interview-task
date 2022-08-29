<?php

namespace App\Infrastructure\Http\AbstractRequests;

use Illuminate\Foundation\Http\FormRequest as Request;

class BaseRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    protected function prepareForValidation(){
        if( method_exists( $this, 'defaults' ) ) {
            foreach ($this->defaults() as $key => $defaultValue) {
                if (!$this->has($key)) $this->merge([$key => $defaultValue]);
            }
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
