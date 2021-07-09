<?php

namespace App\Http\Resources;

use App\Models\Game;
use App\Models\Order;
use App\Models\Round;
use App\Models\RoundOrder;
use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        /* @var  $this Order */
        return [
            'uuid' => $this->uuid,
            'roundSerial' => $this->roundSerial,
            'orderSerial' => $this->orderSerial,
            'transactionDate' => $this->transactionDate,
            'code' => $this->code,
            'email' => $this->email,
            'currency' => $this->currency,
            'stake' => round($this->stake),
            'winning' => round($this->winning),
            'stakeCny' => round($this->stakeCny),
            'winningCny' => round($this->winningCny),
            'showTitle' => "注單編號 「 $this->orderSerial 」",
        ];
    }
}
