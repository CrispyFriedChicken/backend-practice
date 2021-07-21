<?php

namespace App\Http\Controllers\Api;

use App\Enum\GamesEnum;
use App\Helper\ChartHelper;
use App\Helper\QueryHelper;
use App\Http\Resources\OrderSummaryResource;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * 營收分析
     * @param Request $request
     * @return array
     */
    public function revenueAnalysis(Request $request)
    {
        $renderSettings = [];
        //長條圖
        if (1) {
            //查詢資料
            $query = DB::table('orders');
            $this->addConditions($query, $request);
            $query->groupBy(['code']);
            $query->orderBy('code');
            $query->select(['code', DB::raw('SUM(betCny) as betCny'), DB::raw('SUM(totalPayoutCny) * -1 as profitCny')]);
            if ($query->count()) {
                $rows = $query->get();
                //整理橫列
                $labels = ChartHelper::getLabels($rows, 'code', GamesEnum::getCodeChineseNameMap());
                //整理檔案
                $datas = ChartHelper::getDatas($rows, ['betCny', 'profitCny']);
                //設定圖表資訊
                $renderSettings[] = ChartHelper::getSetting(ChartHelper::TYPE_BAR_CHART, '長條圖', $labels, [
                    ChartHelper::getDatasets('投注額', ChartHelper::COLOR_RED, $datas['betCny']),
                    ChartHelper::getDatasets('損益', ChartHelper::COLOR_BLUE, $datas['profitCny']),
                ]);
            }
        }

        //長條圖
        if (1) {
            //折線圖
            $query = DB::table('orders');
            $this->addConditions($query, $request);
            $dateString = QueryHelper::getDateString($request, 'transactionDate');
            $transactionDate = DB::raw($dateString);
            $query->groupBy([$transactionDate]);
            $query->orderBy($transactionDate);
            $query->select([DB::raw("$dateString AS transactionDate"), DB::raw('COUNT(uuid) as orderCount'), DB::raw('SUM(betCny) as betCny'), DB::raw('SUM(totalPayoutCny) * -1 as profitCny')]);
            if ($query->count()) {
                $rows = $query->get();
                //整理橫列
                $labels = ChartHelper::getLabels($rows, 'transactionDate');
                //整理檔案
                $datas = ChartHelper::getDatas($rows, ['betCny', 'profitCny']);
                //設定圖表資訊
                if (count($rows)) {
                    $renderSettings[] = ChartHelper::getSetting(ChartHelper::TYPE_LINE_CHART, '折線圖', $labels, [
                        ChartHelper::getDatasets('投注額', ChartHelper::COLOR_RED, $datas['betCny'], ['fill' => false, 'borderColor' => ChartHelper::COLOR_RED]),
                        ChartHelper::getDatasets('損益', ChartHelper::COLOR_GREEN, $datas['profitCny'], ['fill' => false, 'borderColor' => ChartHelper::COLOR_BLUE]),

                    ]);
                }
            }
        }
        return $renderSettings;
    }


    /**
     * 單量分析
     * @param Request $request
     * @return array
     */
    public function orderCountAnalysis(Request $request)
    {
        $renderSettings = [];
        //長條圖
        if (1) {
            //查詢資料
            $query = DB::table('orders');
            $this->addConditions($query, $request);
            $query->groupBy(['code']);
            $query->orderBy('code');
            $query->select(['code', DB::raw('COUNT(uuid) as orderCount')]);
            if ($query->count()) {
                $rows = $query->get();
                //整理橫列
                $labels = ChartHelper::getLabels($rows, 'code', GamesEnum::getCodeChineseNameMap());
                //整理檔案
                $datas = ChartHelper::getDatas($rows, ['orderCount']);
                //設定圖表資訊
                $renderSettings[] = ChartHelper::getSetting(ChartHelper::TYPE_BAR_CHART, '長條圖', $labels, [
                    ChartHelper::getDatasets('單量', ChartHelper::COLOR_BLUE, $datas['orderCount'])
                ]);
            }
        }
        //折線圖
        if (1) {
            //查詢資料
            $query = DB::table('orders');
            $this->addConditions($query, $request);
            $dateString = QueryHelper::getDateString($request, 'transactionDate');
            $transactionDate = DB::raw($dateString);
            $query->groupBy([$transactionDate]);
            $query->orderBy($transactionDate);
            $query->select([DB::raw("$dateString AS transactionDate"), DB::raw('COUNT(uuid) as orderCount')]);
            if ($query->count()) {
                $rows = $query->get();
                //整理橫列
                $labels = ChartHelper::getLabels($rows, 'transactionDate');
                //整理檔案
                $datas = ChartHelper::getDatas($rows, ['orderCount']);
                //設定圖表資訊
                if (count($rows)) {
                    $renderSettings[] = ChartHelper::getSetting(ChartHelper::TYPE_LINE_CHART, '折線圖', $labels, [
                        ChartHelper::getDatasets('單量', ChartHelper::COLOR_BLUE, $datas['orderCount'], ['fill' => false, 'borderColor' => ChartHelper::COLOR_BLUE])
                    ]);
                }
            }
        }
        return $renderSettings;
    }

    /**
     * 遊戲排行
     * @param Request $request
     * @return array
     */
    public function gameRank(Request $request)
    {
        $renderSettings = [];
        //總損益前10名遊戲 圓餅圖
        if (1) {
            //查詢資料
            $query = DB::table('orders');
            $this->addConditions($query, $request);
            $query->groupBy(['code']);
            $query->orderBy(DB::raw('SUM(totalPayoutCny) * -1'), 'desc');
            $query->select(['code', DB::raw('SUM(totalPayoutCny) * -1 as profitCny')]);
            $query->limit(10);
            if ($query->count()) {
                $rows = $query->get();
                //整理橫列
                $labels = ChartHelper::getLabels($rows, 'code', GamesEnum::getCodeChineseNameMap());
                //整理檔案
                $datas = ChartHelper::getDatas($rows, ['profitCny']);
                //設定圖表資訊
                $renderSettings[] = ChartHelper::getSetting(ChartHelper::TYPE_PIE_CHART, '總損益前10名遊戲', $labels, [
                    ChartHelper::getDatasets('損益', ChartHelper::getColors($rows), $datas['profitCny'], [], ChartHelper::FORMAT_MONEY)
                ]);
            }
        }

        //總單量前10名遊戲 圓餅圖
        if (1) {
            //查詢資料
            $query = DB::table('orders');
            $this->addConditions($query, $request);
            $query->groupBy(['code']);
            $query->orderBy(DB::raw('COUNT(uuid)'), 'desc');
            $query->limit(10);
            $query->select(['code', DB::raw('COUNT(uuid) as orderCount')]);
            if ($query->count()) {
                $rows = $query->get();
                //整理橫列
                $labels = ChartHelper::getLabels($rows, 'code', GamesEnum::getCodeChineseNameMap());
                //整理檔案
                $datas = ChartHelper::getDatas($rows, ['orderCount']);
                //設定圖表資訊
                $renderSettings[] = ChartHelper::getSetting(ChartHelper::TYPE_PIE_CHART, '總單量前10名遊戲', $labels, [
                    ChartHelper::getDatasets('單量', ChartHelper::getColors($rows), $datas['orderCount'], [], ChartHelper::FORMAT_NUMBER)
                ]);
            }
        }
        return $renderSettings;
    }

    /**
     * 玩家排行
     * @param Request $request
     * @return array
     */
    public function playerRank(Request $request)
    {
        $renderSettings = [];

        $playerMap = User::getPlayerEmailTitleMap();
        //贏家 圓餅圖
        if (1) {
            //查詢資料
            $query = DB::table('orders');
            $this->addConditions($query, $request);
            $query->groupBy(['email']);
            $query->orderBy(DB::raw('SUM(totalPayoutCny)'), 'desc');
            $query->select(['email', DB::raw('SUM(totalPayoutCny) as totalPayoutCny')]);
            $query->limit(10);
            if ($query->count()) {
                $rows = $query->get();
                //整理橫列
                $labels = ChartHelper::getLabels($rows, 'email', $playerMap);
                //整理檔案
                $datas = ChartHelper::getDatas($rows, ['totalPayoutCny']);
                //設定圖表資訊
                $renderSettings[] = ChartHelper::getSetting(ChartHelper::TYPE_PIE_CHART, '贏家', $labels, [
                    ChartHelper::getDatasets('派彩', ChartHelper::getColors($rows), $datas['totalPayoutCny'], [], ChartHelper::FORMAT_MONEY)
                ]);
            }
        }

        //輸家 圓餅圖
        if (1) {
            //查詢資料
            $query = DB::table('orders');
            $this->addConditions($query, $request);
            $query->groupBy(['email']);
            $query->orderBy(DB::raw('SUM(totalPayoutCny)'));
            $query->select(['email', DB::raw('SUM(totalPayoutCny) as totalPayoutCny')]);
            $query->limit(10);
            if ($query->count()) {
                $rows = $query->get();
                //整理橫列
                $labels = ChartHelper::getLabels($rows, 'email', $playerMap);
                //整理檔案
                $datas = ChartHelper::getDatas($rows, ['totalPayoutCny']);
                //設定圖表資訊
                $renderSettings[] = ChartHelper::getSetting(ChartHelper::TYPE_PIE_CHART, '輸家', $labels, [
                    ChartHelper::getDatasets('派彩', ChartHelper::getColors($rows), $datas['totalPayoutCny'], [], ChartHelper::FORMAT_MONEY)
                ]);
            }
        }
        return $renderSettings;
    }


    protected function addConditions($query, $request)
    {
        QueryHelper::addConditions($query, $request, [
            QueryHelper::DateSearch => ['transactionDate'],
            QueryHelper::EqualSearch => ['type', 'currency', 'code'],
        ]);
    }
}

