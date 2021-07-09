<?php

namespace App\Helper;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class MenuHelper
{
    public static function getMenuList()
    {
        if (Auth::guest()) {
            $menuList = [
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
                    'url' => 'home',
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
                            'url' => 'players/create',
                            'content' => '新增玩家',
                        ],
                        //玩家一覽
                        [
                            'url' => 'players/list',
                            'content' => '玩家一覽',
                        ],
                    ],
                ],
                // 遊戲維護
                [
                    'id' => 'games',
                    'url' => '',
                    'content' => '<i class="fa fa-fw fa-gamepad"></i> 遊戲維護',
                    'option' => [],
                    'subItems' => [
                        // 新增遊戲
                        [
                            'url' => 'games/create',
                            'content' => '新增遊戲',
                        ],
                        // 遊戲一覽
                        [
                            'url' => 'games/list',
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
                // 每日注單結算報表
                [
                    'id' => 'dailyOrderSummary',
                    'url' => '',
                    'content' => '<i class="fa fa-fw fa-bar-chart"></i> 每日注單結算報表',
                    'option' => [],
                    'subItems' => [],
                ],
                // 登出
                [
                    'id' => 'logout',
                    'url' => '',
                    'content' => '<i class="fa fa-fw fa-sign-out"></i> 登出',
                    'option' => [
                        'onclick' => 'javascript:flash("登出成功", "success");$("#logout-form").submit();',
                    ],
                    'subItems' => [],
                ],
            ];
        }
        return $menuList;
    }

    public static function checkIsSecondLayerActive($subItem)
    {
        return $subItem['url'] ? strpos(Request::path(), $subItem['url']) !== false : false;
    }

    public static function checkIsFirstLayerActive($firstLayer)
    {
        $isFirstLayerActive = false;
        if (isset($firstLayer['subItems']) && count($firstLayer['subItems'])) {
            foreach ($firstLayer['subItems'] as $subItem) {
                if (self::checkIsSecondLayerActive($subItem)) {
                    $isFirstLayerActive = true;
                }
            }
        }
        return $isFirstLayerActive;

    }
}
