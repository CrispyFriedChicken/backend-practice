<?php

namespace App\Helper;

use AmrShawky\LaravelCurrency\Facade\Currency;
use App\Enum\CurrencyEnum;
use App\Enum\GamesEnum;
use App\Enum\UserRoleEnum;
use App\Models\DailyOrderSummary;
use App\Models\Game;
use App\Models\Order;
use App\Models\SerialControl;
use App\Models\SerialSetting;
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
        $exchangeRateMap = [];
        $currencys = array_keys(CurrencyEnum::getKeyValueMap());
        foreach ($currencys as $currency) {
            $exchangeRateMap[$currency] = Currency::rates()
                ->historical(date('Y-m-d', strtotime($currentDate)))
                ->symbols(['CNY'])
                ->base($currency)
                ->get()['CNY'];
        }
        $currentDate = $currentDate == false ? date('Y-m-d H:i:s') : $currentDate;
        $rounds = $roundCount == false ? rand(50, 100) : $roundCount;
        $currentRound = 1;
        while ($currentRound <= $rounds) {
            $orders = $orderCount == false ? rand(0, 10) : $orderCount;
            $currentOrder = 1;
            /* @var  $user User */
            $user = User::where(['role' => UserRoleEnum::PLAYER])->get()->random();
            /* @var  $game Game */
            $game = Game::all()->random();
            $exchangeRate = $exchangeRateMap[$user->currency];
            while ($currentOrder <= $orders) {
                $stake = rand(1, 10000);
                $winning = rand(0, $stake);
                $order = new Order();
                $order->uuid = (string)Uuid::generate(4);
                $order->userUuid = $user->uuid;
                $order->gameUuid = $game->uuid;
                $order->orderSerial = SerialHelper::produce('order', date('Y-m-d', strtotime($currentDate)));
                $order->roundSerial = SerialHelper::produce('round', date('Y-m-d', strtotime($currentDate)));
                $order->transactionDate = $currentDate;
                $order->currency = $user->currency;
                $order->email = $user->email;
                $order->type = $game->type;
                $order->code = $game->code;
                $order->stake = $stake;
                $order->stakeCny = $stake * $exchangeRate;
                $order->winning = $winning;
                $order->winningCny = $winning * $exchangeRate;
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
        $currencyKeyValueMap = CurrencyEnum::getKeyValueMap();
        $summary = [];
        foreach ($rows as $row) {
            foreach (['all', $row['type']] as $type) {
                if (!isset($summary[$type][$row['currency']])) {
                    $summary[$type][$row['currency']] = [
                        'stake' => 0,
                        'winning' => 0,
                        'orderCount' => 0,
                        'rows' => [],
                    ];
                }
                $summary[$type][$row['currency']]['stake'] += $row['stake'];
                $summary[$type][$row['currency']]['winning'] += $row['winning'];
                $summary[$type][$row['currency']]['orderCount']++;
                $summary[$type][$row['currency']]['rows'][] = [
                    $row['roundSerial'],//局號
                    $row['orderSerial'],//注單編號
                    $row['transactionDate'],//下注時間
                    $codeTitleMap[$row['code']],//遊戲名稱
                    $row['email'],//玩家帳號
                    $currencyKeyValueMap[$row['currency']],//幣別
                    $row['stake'],//投注額
                    $row['winning'],//派彩
                    $row['stakeCny'],//投注額(人民幣)
                    $row['winningCny'],//派彩(人民幣)
                ];
            }
        }
        foreach ($summary as $type => $currencys) {
            foreach ($currencys as $currency => $row) {
                $dailyOrderSummary = new DailyOrderSummary();
                $dailyOrderSummary->type = $type;
                $dailyOrderSummary->currency = $currency;
                foreach (['stake', 'winning', 'orderCount'] as $col) {
                    $dailyOrderSummary->$col = $row[$col];
                }
                $dailyOrderSummary->transactionDate = $date;
                $dailyOrderSummary->save();

                //建立報表csv檔案
                if (1) {
                    $fileName = "$date-$type-$currency";
                    $headers = [[
                        '局號',
                        '注單編號',
                        '下注時間',
                        '遊戲名稱',
                        '玩家帳號',
                        '幣別',
                        '投注額',
                        '派彩',
                        '投注額(人民幣)',
                        '派彩(人民幣)',
                    ]];
                    ExportHelper::exportCsvToLocalStorage("/var/www/public/report/dailyOrderSummary/$fileName", $headers, $row['rows']);
                }
            }
        }
    }

}
