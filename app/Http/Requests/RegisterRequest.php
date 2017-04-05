<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class RegisterRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
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
        return [
            'username' => 'bail|required|unique:accounts,username',
            'password' => 'bail|required|min:4|confirmed',
            'password_confirmation' => 'bail|required|min:4',
            'firstName' => 'required',
            'lastName' => 'required',
            'emailAddress' => 'bail|required|email|unique:accounts,email_address',
            'birthDate' => 'bail|required|date'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
