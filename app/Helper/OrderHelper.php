<?php

namespace App\Helper;

use App\Enum\GamesEnum;
use App\Enum\UserRoleEnum;
use App\Models\DailyOrderSummary;
use App\Models\Game;
use App\Models\GameType;
use App\Models\Order;
use App\User;
use \Datetime;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;
use App\Helper\ExportHelper;


class OrderHelper
{
    /**
     * 建立指定日期訂單假資料
     * @param false $currentDate
     * @param false $roundCount
     * @param false $orderCount
     * @throws \Exception
     */
    public static function generateDailyFakeOrders($currentDate = false, $roundCount = false, $orderCount = false)
    {
        //取當日匯率
        $currencyCodeNameMap = \App\Models\Currency::getCodeNameMap();
        $currentDate = $currentDate == false ? date('Y-m-d H:i:s') : $currentDate;
        $rates = \AmrShawky\LaravelCurrency\Facade\Currency::rates()
            ->historical(date('Y-m-d', strtotime($currentDate)))
            ->symbols(array_keys(\App\Models\Currency::getNameCodeMap())) //An array of currency codes to limit output currencies
            ->get();
        $rounds = $roundCount == false ? rand(50, 100) : $roundCount;
        $currentRound = 1;
        while ($currentRound <= $rounds) {
            $orders = $orderCount == false ? rand(0, 10) : $orderCount;
            $currentOrder = 1;
            /* @var  $user User */
            $user = User::where(['role' => UserRoleEnum::PLAYER])->get()->random();
            /* @var  $game Game */
            $game = Game::all()->random();
            $userExchangeRate = $rates[$currencyCodeNameMap[$user->currency]];
            $cnyExchangeRate = $rates['CNY'];
            $exchangeRate = $cnyExchangeRate / $userExchangeRate;
            $roundSerial = SerialHelper::produce('round', date('Y-m-d', strtotime($currentDate)));
            while ($currentOrder <= $orders) {
                $bet = rand(1, 10000);
                $totalWin = rand(0, $bet * 1.8);
                $totalPayout = $totalWin - $bet;
                $order = new Order();
                $order->uuid = (string)Uuid::generate(4);
                $order->userUuid = $user->uuid;
                $order->gameUuid = $game->uuid;
                $order->roundSerial = $roundSerial;
                $order->orderSerial = SerialHelper::produce('order', date('Y-m-d', strtotime($currentDate)));
                $order->transactionDate = $currentDate;
                $order->currency = $user->currency;
                $order->email = $user->email;
                $order->type = $game->type;
                $order->code = $game->code;
                $order->exchangeRate = $userExchangeRate;
                $order->exchangeRateCny = $cnyExchangeRate;
                $order->bet = $bet;
                $order->betCny = $bet * $exchangeRate;
                $order->totalWin = $totalWin;
                $order->totalWinCny = $totalWin * $exchangeRate;
                $order->totalPayout = $totalPayout;
                $order->totalPayoutCny = $totalPayout * $exchangeRate;
                $order->save();
                $currentOrder++;
            }
            $currentRound++;
        }
    }

    /**
     * 日結訂單資料
     * @param string $date
     * @return string
     * @throws \Exception
     */
    public static function generateDailySummary(string $date = '')
    {
        $date = $date == '' ? date('Y-m-d', strtotime('yesterday')) : $date;
        $queryResult = DB::table('orders')
            ->where('transactionDate', 'LIKE', '%' . $date . '%')
            ->get();
        $rows = json_decode(json_encode($queryResult), true);
        $codeTitleMap = GamesEnum::getCodeTitleMap();

        $typeCodeTitleMap = GameType::getCodeTitleMap(true);
        $currencyCodeTitleMap = \App\Models\Currency::getCodeTitleMap();
        $summary = [];
        foreach ($rows as $row) {
            foreach ([GameType::ALL_TYPE, $row['type']] as $type) {
                if (!isset($summary[$type][$row['currency']])) {
                    $summary[$type][$row['currency']] = [
                        'bet' => 0,
                        'totalPayout' => 0,
                        'orderCount' => 0,
                        'rows' => [],
                    ];
                }
                $summary[$type][$row['currency']]['bet'] += $row['bet'];
                $summary[$type][$row['currency']]['totalPayout'] += $row['totalPayout'];
                $summary[$type][$row['currency']]['orderCount']++;
                $summary[$type][$row['currency']]['rows'][] = [
                    $row['roundSerial'],//局號
                    $row['orderSerial'],//注單編號
                    $row['transactionDate'],//下注時間
                    $codeTitleMap[$row['code']],//遊戲名稱
                    $row['email'],//玩家帳號
                    $currencyCodeTitleMap[$row['currency']],//幣別
                    $row['exchangeRate'],//原幣別匯率
                    $row['exchangeRateCny'],//人民幣匯率
                    $row['totalWin'],//總贏分
                    $row['bet'],//投注額
                    $row['totalPayout'],//派彩
                    $row['totalWinCny'],//總贏分(人民幣)
                    $row['betCny'],//投注額(人民幣)
                    $row['totalPayoutCny'],//派彩(人民幣)
                ];
            }
        }
        foreach ($summary as $type => $currencys) {
            foreach ($currencys as $currency => $row) {
                $dailyOrderSummary = new DailyOrderSummary();
                $dailyOrderSummary->type = $type;
                $dailyOrderSummary->currency = $currency;
                foreach (['bet','totalWin', 'totalPayout', 'orderCount'] as $col) {
                    $dailyOrderSummary->$col = $row[$col];
                }
                $dailyOrderSummary->transactionDate = $date;
                $dailyOrderSummary->save();

                //建立報表csv檔案
                if (1) {
                    $fileName = "$date-{$typeCodeTitleMap[$type]}-{$currencyCodeTitleMap[$currency]}";
                    $headers = [[
                        '局號',
                        '注單編號',
                        '下注時間',
                        '遊戲名稱',
                        '玩家帳號',
                        '幣別',
                        '原幣別匯率',
                        '人民幣匯率',
                        '總贏分',
                        '投注額(人民幣)',
                        '派彩',
                        '總贏分',
                        '投注額(人民幣)',
                        '派彩(人民幣)',
                    ]];
                    ExportHelper::exportCsvToLocalStorage("/var/www/public/report/dailyOrderSummary/$fileName", $headers, $row['rows']);
                }
            }
        }
    }

}
