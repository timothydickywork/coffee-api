<?php

namespace App\Http\Requests;

use Dingo\Api\Http\FormRequest;

class SetupPointsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'min_transaction' => [
                'required',
                'integer'
            ],
            'start_date' => [
                'required',
                'date',
                'date_format:Y-m-d',
                'after:now'
            ],
            'expiration_day' => [
                'required',
                'integer',
                'min:1'
            ],
        ];
    }
}
