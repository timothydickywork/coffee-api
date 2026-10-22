<?php

namespace App\Http\Requests;

use Dingo\Api\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => [
                'required',
                'min:3',
                'max:255'
            ],
            'phone' => [
                'required',
                'min:3',
                'max:16',
                'regex:/\+?([ -]?\d+)+|\(\d+\)([ -]\d+)/'
            ],
            'address' => [
                'required',
                'min:3',
                'max:255'
            ],
        ];
    }
}
