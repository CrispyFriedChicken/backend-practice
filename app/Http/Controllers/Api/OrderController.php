<?php

namespace App\Http\Controllers\Api;

use App\Models\Currency;
use App\Models\GameType;
use App\Helper\QueryHelper;
use App\Http\Requests\GameRequest;
use App\Http\Resources\GameResource;
use App\Http\Resources\OrderResource;
use App\Models\Game;
use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{

    /**
     * 列出注單
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function list(Request $request)
    {
        $query = DB::table('orders');
        $this->addQueryConditions($query, $request);
        //排序
        if ($request->sortColumn && $request->sortBy) {
            $query = $query->orderBy($request->sortColumn, $request->sortBy);
        }
        $query = $query->orderBy('roundSerial', 'asc');
        $query = $query->paginate();
        return OrderResource::collection($query);
    }


    /**
     * 根據條件計算總合併回傳相關結果文字
     * @param Request $request
     * @return array
     */
    public function summary(Request $request)
    {
        $query = DB::table('orders');
        $this->addQueryConditions($query, $request);
        $rows = $query
            ->groupBy('type', 'currency')
            ->select([
                'type',
                'currency',
                DB::raw('SUM(bet) as bet'),
                DB::raw('SUM(totalPayout) as totalPayout'),
                DB::raw('COUNT(uuid) as orderCount')
            ])->get();


        $template = [
            'totalPayout' => 0,
            'bet' => 0,
            'orderCount' => 0,
        ];

        $summary = [];
        $gameTypes = GameType::get();
        foreach ($gameTypes as $gameType) {
            $summary[$gameType->code] = [];
        }
        $summary[GameType::ALL_TYPE] = [];

        foreach ($rows as $row) {
            if (!isset($summary[GameType::ALL_TYPE][$row->currency])) {
                $summary[GameType::ALL_TYPE][$row->currency] = $template;
            }
            if (!isset($summary[$row->type][$row->currency])) {
                $summary[$row->type][$row->currency] = $template;
            }
            foreach (['totalPayout', 'bet', 'orderCount'] as $col) {
                $summary[GameType::ALL_TYPE][$row->currency][$col] += $row->$col;
                $summary[$row->type][$row->currency][$col] += $row->$col;
            }
        }
        foreach ($summary as $type => $currencyCodes) {
            ksort($summary[$type]);
        }
        $gameTypeCodeTitleMap = GameType::getCodeTitleMap(true);
        $currencyCodeTitleMap = Currency::getCodeTitleMap();
        $showTexts = [];
        foreach ($summary as $type => $currencyCodes) {
            $bets = [];
            $totalPayouts = [];
            $totalCount = 0;
            foreach ($currencyCodes as $currencyCode => $info) {
                $currency = $currencyCodeTitleMap[$currencyCode];
                $bets[] = $currency . ' $ ' . number_format($info['bet']);
                $totalPayouts[] = $currency . ' $ ' . number_format($info['totalPayout']);
                $totalCount += $info['orderCount'];
            }
            $isShowText = $type == GameType::ALL_TYPE ? count($showTexts) > 1 : $totalCount > 0;
            if ($isShowText) {
                $showTexts[] = [
                    'title' => $gameTypeCodeTitleMap[$type],
                    'texts' => [
                        '總投注額 : ' . implode($bets, "　/　"),
                        '總派彩 : ' . implode($totalPayouts, "　/　"),
                        '總訂單數 : ' . number_format($totalCount)
                    ],
                ];
            }
        }
        return $showTexts;
    }

    /**
     * 新增查詢條件
     * @param $query
     * @param $request
     */
    protected function addQueryConditions(&$query, $request)
    {
        QueryHelper::addConditions($query, $request, [
            QueryHelper::FuzzySearch => [
                'roundSerial',
                'orderSerial',
                'email',
            ],
            QueryHelper::EqualSearch => [
                'currency',
                'code',
                'type',
            ],
            QueryHelper::DateSearch => ['transactionDate'],
        ]);
    }
}

