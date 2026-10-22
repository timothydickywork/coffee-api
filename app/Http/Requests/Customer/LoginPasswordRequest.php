<?php

namespace App\Http\Requests\Customer;

use Dingo\Api\Http\FormRequest;

class LoginPasswordRequest extends FormRequest
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
            'password' => [
                'required'
            ],
        ];
    }
}
