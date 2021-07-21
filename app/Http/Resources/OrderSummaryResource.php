<?php

namespace App\Http\Resources;

use App\Models\Currency;
use App\Models\DailyOrderSummary;
use App\Models\GameType;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderSummaryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        /* @var  $this DailyOrderSummary */
        $typeCodeTitleMap = GameType::getCodeTitleMap(true);
        $currencyCodeTitleMap = Currency::getCodeTitleMap();
        $dateString = date('Ymd', strtotime($this->transactionDate));
        return [
            'totalWin' => $this->totalWin,
            'bet' => $this->bet,
            'totalPayout' => $this->totalPayout,
            'type' => $this->type,
            'transactionDate' => $this->transactionDate,
            'orderCount' => $this->orderCount,
            'currency' => $this->currency,
            'url' => url("report/dailyOrderSummary/{$this->transactionDate}-{$typeCodeTitleMap[$this->type]}-{$currencyCodeTitleMap[$this->currency]}.csv"),
            'showTitle' => "{$dateString}-{$typeCodeTitleMap[$this->type]}-{$currencyCodeTitleMap[$this->currency]}-日結報表",
        ];
    }
}
