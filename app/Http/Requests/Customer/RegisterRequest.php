<?php

namespace App\Http\Requests\Customer;

use Dingo\Api\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        // English uppercase characters (A – Z)
        // English lowercase characters (a – z)
        // Base 10 digits (0 – 9)
        // Non-alphanumeric (For example: !, $, #, or %)
        // Unicode characters
        return [
            'name' => [
                'required',
            ],
            'password' => [
                'required',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/',
                'confirmed'
            ],
            'email' => [
                'required', 
                'email', 
                'unique:customer',
            ],
            'uid' => [
                'required', 
                'unique:customer',
            ],
        ];
    }
}
