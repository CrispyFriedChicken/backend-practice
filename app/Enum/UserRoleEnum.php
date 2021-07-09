<?php

namespace App\Enum;

class UserRoleEnum
{
    const PLAYER = 'PLAYER';
    const MANAGER = 'MANAGER';
    const ADMIN = 'ADMIN';

    public static function getKeyValueMap()
    {
        return [
            self::PLAYER => '玩家',
            self::MANAGER => '後台管理員',
            self::ADMIN => '系統管理員',
        ];
    }
}
