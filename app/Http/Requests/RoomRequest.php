<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'     => 'required',
            'lat'       => 'required|numeric',
            'lang'      => 'required|numeric',
            'comment'   => 'nullable|max:5000',
            'address'   => 'required',
            'access'    => 'nullable',
            'zipcode'   => ['required', new \App\Rules\PostalCode()]
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'title'     => 'タイトル',
            'lat'       => '緯度',
            'lang'      => '軽度',
            'comment'   => 'コメント',
            'address'   => '住所',
            'access'    => 'アクセス',
            'zipcode'   => '郵便番号'
        ];
    }

    /**
     * Get the validation messages that apply to the request.
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
