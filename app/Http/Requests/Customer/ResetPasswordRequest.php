<?php

namespace App\Http\Requests\Customer;

use Dingo\Api\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => [
                'required',
                'email'
            ],
        ];
    }
}
