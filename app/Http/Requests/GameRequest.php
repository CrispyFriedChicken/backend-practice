<?php

namespace App\Http\Requests;

use App\Enum\GameTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GameRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'chineseName' => "required|unique:games,chineseName" . ($this->uuid ? ",{$this->uuid},uuid" : ''),
            'englishName' => "required|unique:games,englishName" . ($this->uuid ? ",{$this->uuid},uuid" : ''),
            'code' => "required|unique:games,code" . ($this->uuid ? ",{$this->uuid},uuid" : ''),
            'type' => 'required|' . Rule::in(array_keys(GameTypeEnum::getKeyValueMap())),
        ];
    }

    public function attributes()
    {
        return [
            'chineseName' => '中文名稱',
            'englishName' => '英文名稱',
            'code' => '遊戲代號',
            'type' => '遊戲類型',
        ];
    }

}
