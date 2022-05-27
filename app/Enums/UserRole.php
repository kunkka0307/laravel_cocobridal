<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class UserRole extends Enum
{
    const ADMINISTRATOR = 1;
    const USER = 2;

    public static function getAllValues()
    {
        return [
            self::ADMINISTRATOR             => __("管理者"),
            self::USER                     => __("ユーザー")
        ];
    }
}
