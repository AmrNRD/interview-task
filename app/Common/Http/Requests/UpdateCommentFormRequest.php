<?php

namespace App\Common\Http\Requests;

use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;

class UpdateCommentFormRequest extends FormRequest
{
    /**
     * Determine if the User is authorized to make this request.
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
            'user_id' => ['nullable'],
            'body'        => ['required', 'string'],
        ];
        return $rules;
    }


}
