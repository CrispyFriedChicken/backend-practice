<?php

namespace App\Enum;

class CurrencyEnum
{
    const TWD = 'TWD';
    const USD = 'USD';
//    const GBD = 'GBD';
    const CNY = 'CNY';

    public static function getKeyValueMap()
    {
        return [
            self::TWD => '台幣',
            self::USD => '美金',
//            self::GBD => '英鎊',
            self::CNY => '人民幣',
        ];
    }
}
