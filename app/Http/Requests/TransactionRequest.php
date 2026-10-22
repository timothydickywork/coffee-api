<?php

namespace App\Http\Requests;

use Dingo\Api\Http\FormRequest;

class TransactionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'store_id' => [
                'required',
                'integer',
                'exists:store,id'
            ],
            'transaction_number' => [
                'required',
                'unique:transaction'
            ],
            'customer_code' => [
                'required',
                'exists:customer,code'
            ],
            'amount' => [
                'required',
                'integer'
            ],
            'date' => [
                'required',
                'date',
                'date_format:Y-m-d H:i:s',
                'before_or_equal:now'
            ],
        ];
    }
}
