<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class BookStatus extends Enum
{
    const RESERVED = 1;
    const FINISHED = 2;
    const CANCEL   = 5;

    public static function getAllValues()
    {
        return [
            self::RESERVED              => '予約済み',
            self::FINISHED              => '予約完了',
            self::CANCEL                => '予約キャンセル'
        ];
    }
}
