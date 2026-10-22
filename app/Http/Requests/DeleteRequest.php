<?php

namespace App\Http\Requests;

use Dingo\Api\Http\FormRequest;

class DeleteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        // return true;
        return [
            'id' => [
                'required',
                'integer',
            ],
            'delete_reason' => [
                'required',
                'min:3',
                'max:255'
            ]
        ];
    }
}
