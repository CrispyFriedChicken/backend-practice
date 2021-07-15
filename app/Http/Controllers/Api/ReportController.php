<?php

namespace App\Http\Controllers\Api;

use App\Enum\GamesEnum;
use App\Helper\ChartHelper;
use App\Helper\QueryHelper;
use App\Http\Resources\OrderSummaryResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * 取得長條圖資料
     * @param Request $request
     * @return array
     */
    public function barChart(Request $request)
    {
        //查詢資料
        $query = DB::table('orders');
        QueryHelper::addConditions($query, $request, [
            QueryHelper::DateSearch => ['transactionDate'],
            QueryHelper::EqualSearch => ['type', 'currency', 'code'],
        ]);
        $query->groupBy(['code']);
        $query->orderBy('code');
        $query->select(['code', DB::raw('COUNT(uuid) as orderCount'), DB::raw('SUM(stakeCny) as stakeCny'), DB::raw('SUM(winningCny) as winningCny')]);

        $renderSettings = [];
        if ($query->count()) {
            $rows = $query->get();
            //整理橫列
            $labels = [];
            $codeTitleMap = GamesEnum::getCodeChineseNameMap();
            foreach ($rows as $row) {
                $labels[] = @(string)$codeTitleMap[$row->code];
            }
            //整理檔案
            $datas = [];
            $cols = [
                'orderCount',
                'stakeCny',
                'winningCny',
            ];
            foreach ($rows as $row) {
                foreach ($cols as $col) {
                    if (!isset($datas[$col])) {
                        $datas[$col] = [];
                    }
                    $datas[$col][] = (int)$row->$col;
                }
            }
            //設定單量圖資訊
            $renderSettings[] = ChartHelper::getSetting(ChartHelper::TYPE_BAR_CHART, '單量', $labels, [
                ChartHelper::getDatasets('單量', ChartHelper::COLOR_BLUE, $datas['orderCount'])
            ]);

            $renderSettings[] = ChartHelper::getSetting(ChartHelper::TYPE_BAR_CHART, '投注額 && 派彩', $labels, [
                ChartHelper::getDatasets('投注額', ChartHelper::COLOR_RED, $datas['stakeCny']),
                ChartHelper::getDatasets('派彩', ChartHelper::COLOR_GREEN, $datas['winningCny']),
            ]);
        }
        return $renderSettings;
    }


    /**
     * 取得折線圖資料
     * @param Request $request
     * @return array
     */
    public function lineChart(Request $request)
    {
        //查詢資料
        $query = DB::table('orders');
        QueryHelper::addConditions($query, $request, [
            QueryHelper::DateSearch => ['transactionDate'],
            QueryHelper::EqualSearch => ['type', 'currency', 'code'],
        ]);
        $transactionDate = DB::raw('SUBSTRING(`transactionDate`,1,10)');
        $query->groupBy([$transactionDate]);
        $query->orderBy($transactionDate);
        $query->select([DB::raw('SUBSTRING(`transactionDate`,1,10) AS transactionDate'), DB::raw('COUNT(uuid) as orderCount'), DB::raw('SUM(stakeCny) as stakeCny'), DB::raw('SUM(winningCny) as winningCny')]);

        $renderSettings = [];
        if ($query->count()) {
            $rows = $query->get();
            //整理橫列
            $labels = [];
            foreach ($rows as $row) {
                $labels[] = $row->transactionDate;
            }
            //整理檔案
            $datas = [];
            $cols = [
                'orderCount',
                'stakeCny',
                'winningCny',
            ];
            foreach ($cols as $col) {
                $datas[$col] = [];
            }
            foreach ($rows as $row) {
                foreach ($cols as $col) {
                    $datas[$col][] = (int)$row->$col;
                }
            }
            //設定單量圖資訊
            if (count($rows)) {
                $renderSettings[] = ChartHelper::getSetting(ChartHelper::TYPE_LINE_CHART, '單量', $labels, [
                    ChartHelper::getDatasets('單量', ChartHelper::COLOR_BLUE, $datas['orderCount'], ['fill' => false, 'borderColor' => ChartHelper::COLOR_BLUE])
                ]);

                $renderSettings[] = ChartHelper::getSetting(ChartHelper::TYPE_LINE_CHART, '投注額 && 派彩', $labels, [
                    ChartHelper::getDatasets('投注額', ChartHelper::COLOR_RED, $datas['stakeCny'], ['fill' => false, 'borderColor' => ChartHelper::COLOR_RED]),
                    ChartHelper::getDatasets('派彩', ChartHelper::COLOR_GREEN, $datas['winningCny'], ['fill' => false, 'borderColor' => ChartHelper::COLOR_GREEN]),
                ]);
            }
        }
        return $renderSettings;
    }
}

