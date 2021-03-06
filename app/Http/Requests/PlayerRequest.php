<?php

namespace App\Http\Requests;

use App\Models\Currency;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PlayerRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'max:100', 'email', "unique:users,email" . ($this->uuid ? ",{$this->uuid},uuid" : '')],
            'password' => $this->uuid ? [] : ['required', 'string', 'min:8', 'confirmed'],
            'currency' => ['required', 'string', 'max:30', Rule::in(array_keys(Currency::getCodeTitleMap()))]
        ];
    }

    public function attributes()
    {
        return [
            'name' => '玩家名稱',
            'email' => '玩家信箱',
            'currency' => '幣別',
            'password' => '密碼',
        ];
    }

}
