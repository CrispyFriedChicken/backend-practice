<?php

namespace App\Http\Controllers\Api;

use App\Enum\GameTypeEnum;
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
                DB::raw('SUM(stake) as stake'),
                DB::raw('SUM(winning) as winning'),
                DB::raw('COUNT(uuid) as orderCount')
            ])->get();


        $template = [
            'winning' => 0,
            'stake' => 0,
            'orderCount' => 0,
        ];
        $summary = [
            GameTypeEnum::slot => [],
            GameTypeEnum::fish => [],
            GameTypeEnum::poker => [],
            'total' => [],
        ];
        foreach ($rows as $row) {
            if (!isset($summary['total'][$row->currency])) {
                $summary['total'][$row->currency] = $template;
            }
            if (!isset($summary[$row->type][$row->currency])) {
                $summary[$row->type][$row->currency] = $template;
            }
            foreach (['winning', 'stake', 'orderCount'] as $col) {
                $summary['total'][$row->currency][$col] += $row->$col;
                $summary[$row->type][$row->currency][$col] += $row->$col;
            }
        }
        foreach ($summary as $type => $currencys) {
            ksort($summary[$type]);
        }
        $keyValueMap = array_merge(GameTypeEnum::getKeyValueMap(), ['total' => '總共']);
        $showTexts = [];
        foreach ($summary as $type => $currencys) {
            $stakes = [];
            $winnings = [];
            $totalCount = 0;
            foreach ($currencys as $currency => $info) {
                $stakes[] = $currency . '$ ' . number_format($info['stake']);
                $winnings[] = $currency . '$ ' . number_format($info['winning']);
                $totalCount += $info['orderCount'];
            }
            $isShowText = $type == 'total' ? count($showTexts) > 1 : $totalCount > 0;
            if ($isShowText) {
                $showTexts[] = [
                    'title' => $keyValueMap[$type],
                    'texts' => [
                        '總投注額 : ' . implode($stakes, "　/　"),
                        '總派彩 : ' . implode($winnings, "　/　"),
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
                'code',
            ],
            QueryHelper::EqualSearch => [
                'currency',
                'type',
            ],
            QueryHelper::DateSearch => ['transactionDate'],
        ]);
    }
}

