<?php

namespace App\Http\Resources;

use App\Models\DailyOrderSummary;
use App\Models\Game;
use App\Models\Round;
use App\Models\RoundOrder;
use App\User;
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
        return [
            'stake' => $this->stake,
            'winning' => $this->winning,
            'type' => $this->type,
            'transactionDate' => $this->transactionDate,
            'orderCount' => $this->orderCount,
            'currency' => $this->currency,
            'url' => url('report/dailyOrderSummary/' . "{$this->transactionDate}-{$this->type}-{$this->currency}" . '.csv'),
            'showTitle' => "局號「 $this->transactionDate 」",
        ];
    }
}
