<?php

namespace App\Http\Requests;

use App\Enum\GameTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ApiLoginRequest extends FormRequest
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
            'email' => [
                'required',
                'string',
                'max:100',
                'email'
            ],
            'password' => ['required'],
        ];
    }

    public function attributes()
    {
        return [
            'email' => '帳號',
            'password' => '密碼',
        ];
    }

}
