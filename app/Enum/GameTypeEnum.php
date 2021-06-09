<?php

namespace App\Enum;

class GameTypeEnum
{
    const slot = 'slot';
    const fish = 'fish';
    const poker = 'poker';

    public static function getKeyValueMap()
    {
        return [
            self::slot => 'Slot',
            self::fish => 'Fish',
            self::poker => 'Poker',
        ];
    }
}
