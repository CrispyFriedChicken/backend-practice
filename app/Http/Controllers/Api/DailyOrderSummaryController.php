<?php

namespace App\Http\Controllers\Api;

use App\Helper\QueryHelper;
use App\Http\Resources\OrderSummaryResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DailyOrderSummaryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 列出遊戲
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function list(Request $request)
    {
        $query = DB::table('dailyOrderSummary');
        QueryHelper::addConditions($query, $request, [
            QueryHelper::DateSearch => ['transactionDate'],
            QueryHelper::EqualSearch => ['type', 'currency'],
        ]);
        //排序
        if ($request->sortColumn && $request->sortBy) {
            $query->orderBy($request->sortColumn, $request->sortBy);
        }
        $query = $query->paginate();
        return OrderSummaryResource::collection($query);
    }
}

