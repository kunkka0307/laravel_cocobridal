<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Hira implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (preg_match("/^[ぁ-ん 　ー]+$/u", $value)) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'ひらがなで入力してください。';
    }
}
