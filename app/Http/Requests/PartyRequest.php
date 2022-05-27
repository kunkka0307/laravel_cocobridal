<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class PartyRequest extends FormRequest
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
            'title'                 => ['required'],
            'eyecatch'              => ['required'],
            'male_limit'            => ['nullable', 'numeric', 'min: 0'],
            'female_limit'          => ['nullable', 'numeric', 'min: 0'],
            'male_price'            => ['required', 'numeric', 'min: 0', 'max: 999999'],
            'female_price'          => ['required', 'numeric', 'min: 0', 'max: 999999'],
            'room_id'               => ['required'],
            'content'               => ['required'],
            'open_date'             => ['required'],
            'open_time'             => ['required'],
            'close_time'            => ['required'],
            'male_high_age'         => ['nullable', 'numeric', 'min: 0', 'max: 120'],
            'male_low_age'          => ['nullable', 'numeric', 'min: 0', 'max: 120'],
            'female_high_age'       => ['nullable', 'numeric', 'min: 0', 'max: 120'],
            'female_low_age'        => ['nullable', 'numeric', 'min: 0', 'max: 120'],
            'value_sense'           => ['nullable', 'numeric', 'min: 0', 'max: 999999'],
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
            'title'                 => 'タイトル',
            'eyecatch'              => 'アイキャッチ画像',
            'male_limit'            => '男性座席数',
            'female_limit'          => '女性座席数',
            'male_price'            => '男性料金',
            'female_price'          => '女性料金',
            'room_id'               => '会場',
            'content'               => '詳細',
            'open_date'             => '開始日',
            'open_time'             => '開始時間',
            'close_time'            => '終了時間',
            'male_high_age'         => '男性年齢上限',
            'male_low_age'          => '男性年齢下限',
            'female_high_age'       => '女性年齢上限',
            'female_low_age'        => '女性年齢下限',
            'value_sense'           => '価値観',
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
