<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class Gender extends Enum
{
    const MALE              = 'male';
    const FEMALE            = 'female';
    const OTHER             = 'other';
    const NO_ANSWER         = 'no_answer';

    const ALL_OPTIONS = [self::MALE, self::FEMALE, self::OTHER, self::NO_ANSWER];

    public static function getAllValues()
    {
        return [
            self::MALE              => __("男性"),
            self::FEMALE            => __("女性"),
            self::OTHER             => __("その他"),
            self::NO_ANSWER         => __("無回答"),
        ];
    }
}
