<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $user_id = $this->input('user_id');
        return [
            'email'                => ['required', 'unique:users,email,' . $user_id . ',id'],
            'password'             => [isset($user_id) ? 'nullable' : 'required', 'min: 8'],
            'firstname'                 => ['required', new \App\Rules\Kanji()],
            'lastname'                  => ['required', new \App\Rules\Kanji()],
            'furi_firstname'            => ['required', new \App\Rules\Hira()],
            'furi_lastname'             => ['required', new \App\Rules\Hira()],
            'gender'                    => ['required'],
            'birthday'                  => ['required'],
            'phone'                     => ['required', new \App\Rules\Tel()],
            'pref'                      => ['required', new \App\Rules\PostalCode()],
            'comment'                   => ['nullable', 'max: 5000'],
            'job'                       => ['nullable'],
            'height'                    => ['nullable', 'numeric', 'min: 0', 'max: 250'],
            'income'                    => ['nullable'],
            'holiday'                   => ['nullable'],
            'hobby'                     => ['nullable'],
            'dwelling'                  => ['nullable'],
            'drink'                     => ['nullable'],
            'smoking'                   => ['nullable'],
            'cooking'                   => ['nullable'],
            'best_cooking'              => ['nullable'],
            'birthplace'                => ['nullable'],
            'bloodtype'                 => ['nullable'],
            'family'                    => ['nullable'],
            'marriage_history'          => ['nullable'],
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
            'email'                    => 'メールアドレス',
            'password'                 => 'パスワード',
            'firstname'                     => '姓',
            'lastname'                      => '名',
            'furi_firstname'                => 'せい',
            'furi_lastname'                 => 'めい',
            'gender'                        => '性別',
            'birthday'                      => '生年月日',
            'phone'                         => '携帯電話番号',
            'pref'                          => '都道府県',
            'comment'                       => '自己紹介',
            'job'                           => '職業',
            'height'                        => '身長',
            'income'                        => '年収',
            'holiday'                       => '休日',
            'hobby'                         => '趣味',
            'dwelling'                      => '現在の住居',
            'drink'                         => 'お酒',
            'smoking'                       => '喫煙',
            'cooking'                       => '料理',
            'best_cooking'                  => '得意料理',
            'birthplace'                    => '出身地',
            'bloodtype'                     => '血液型',
            'family'                        => '続柄',
            'marriage_history'              => '婚姻歴',
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
