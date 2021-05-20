<?php

namespace App\Helper;

use Illuminate\Support\Facades\Auth;

class CommonHelper
{
    public static function getMenuList()
    {
        if (Auth::guest()) {
            $menuList = [
                // 註冊
                [
                    'id' => 'store_list',
                    'url' => 'register',
                    'content' => '<i class="fa fa-fw fa-sign-in"></i> 註冊',
                    'option' => [],
                    'subItems' => [],
                ],
                // 登入
                [
                    'id' => 'store_list',
                    'url' => 'login',
                    'content' => '<i class="fa fa-fw fa-user"></i> 登入',
                    'option' => [],
                    'subItems' => [],
                ],
            ];
        } else {
            $menuList = [
                // 首頁
                [
                    'id' => 'home',
                    'url' => '',
                    'content' => '<i class="fa fa-fw fa-home"></i> 首頁',
                    'option' => [],
                    'subItems' => [],
                ],
                // 玩家維護
                [
                    'id' => 'player',
                    'url' => '',
                    'content' => '<i class="fa fa-fw fa-user"></i> 玩家維護',
                    'subItems' => [
                        //新增玩家
                        [
                            'url' => '',
                            'content' => '新增玩家',
                        ],
                        //玩家一覽
                        [
                            'url' => '',
                            'content' => '玩家一覽',
                        ],
                    ],
                ],
                // 遊戲維護
                [
                    'id' => 'game',
                    'url' => '',
                    'content' => '<i class="fa fa-fw fa-gamepad"></i> 遊戲維護',
                    'option' => [],
                    'subItems' => [
                        // 新增遊戲
                        [
                            'url' => '',
                            'content' => '新增遊戲',
                        ],
                        // 遊戲一覽
                        [
                            'url' => '',
                            'content' => '遊戲一覽',
                        ],
                    ],
                ],
                // 注單查詢
                [
                    'id' => 'order',
                    'url' => '',
                    'content' => '<i class="fa fa-fw fa-search"></i> 注單查詢',
                    'option' => [],
                    'subItems' => [],
                ],
                // 報表分析
                [
                    'id' => 'report',
                    'url' => '',
                    'content' => '<i class="fa fa-fw fa-bar-chart"></i> 報表分析',
                    'option' => [],
                    'subItems' => [
                        // 每日注單結算報表
                        [
                            'url' => '',
                            'content' => '每日注單結算報表',
                        ],
                    ],
                ],
                // 登出
                [
                    'id' => 'logout',
                    'url' => '',
                    'content' => '<i class="fa fa-fw fa-sign-out"></i> 登出',
                    'option' => [
                        'onclick' => 'javascript:$("#logout-form").submit();',
                    ],
                    'subItems' => [],
                ],
            ];
        }
        return $menuList;
    }
}
