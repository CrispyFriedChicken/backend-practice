<?php

namespace App\Http\Requests;

use App\Models\GameType;
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
            'chineseName' => ['required', 'string', 'max:100', "unique:games,chineseName" . ($this->uuid ? ",{$this->uuid},uuid" : '')],
            'englishName' => ['required', 'string', 'max:100', "unique:games,englishName" . ($this->uuid ? ",{$this->uuid},uuid" : '')],
            'type' => ['required', 'string', 'max:30', Rule::in(array_keys(GameType::getCodeTitleMap()))]
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
