<?php

namespace App\Http\Requests\Customer;

use Dingo\Api\Http\FormRequest;

class CustomerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => [
                'required'
            ],
        ];
    }
}
