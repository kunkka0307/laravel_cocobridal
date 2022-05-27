<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TagCrudRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        return [
            'title' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'title'        => 'タグ名',
        ];
    }
}
