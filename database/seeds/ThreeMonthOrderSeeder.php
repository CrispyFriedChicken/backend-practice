<?php

use App\Helper\OrderHelper;
use Illuminate\Database\Seeder;
use App\Helper\SerialHelper;
use App\Enum\UserRoleEnum;
use App\Models\Order;
use App\Models\Game;
use AmrShawky\LaravelCurrency\Facade\Currency;
use App\User;

class ThreeMonthOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 查看每日注單結算報表功能
        //（需使用排程每日結算，搜尋條件-日期，顯示欄位-遊戲分類[slot、poker、fish]、總單量、總投注、總派彩）
        $dateFormat = 'Y-m-d H:i:s';
        $startDate = date($dateFormat, strtotime('-3 month'));
        $endDate = date($dateFormat);
        $currentDate = $startDate;
        while ($currentDate <= $endDate) {
            //產生今日的注單
            OrderHelper::generateDailyFakeOrders($currentDate);
            //結算昨日訂單
            if ($currentDate !== $endDate) {
                OrderHelper::generateDailySummary(date('Y-m-d', strtotime($currentDate)));
            }
            $currentDate = date($dateFormat, strtotime($currentDate . '+1day'));
        }
    }
}
