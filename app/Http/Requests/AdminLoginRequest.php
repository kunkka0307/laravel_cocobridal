<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminLoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password' => 'required',
            'email' => 'required|email',
        ];
    }

    public function attributes()
    {
        return [
            'email'        => 'メールアドレス',
            'password'     => 'パスワード'
        ];
    }
}
