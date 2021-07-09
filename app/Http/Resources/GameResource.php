<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'uuid' => $this->uuid,
            'chineseName' => $this->chineseName,
            'englishName' => $this->englishName,
            'code' => $this->code,
            'type' => $this->type,
            'showTitle' => "$this->code - $this->chineseName ( $this->englishName )",
        ];
    }
}
