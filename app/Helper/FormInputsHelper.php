<?php

namespace App\Helper;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class FormInputsHelper
{

    const formInputTemplate = [
        'type' => '',
        'class' => '',
        'remark' => [],
        'inputAttrs' => [],
    ];

    const inputAttrsTemplate = [
        'title' => '',
        'name' => '',
        'placeholder' => false,
        'list' => false,
    ];

    const remarkTemplate = [
        'class' => 'alert alert-primary',
        'content' => '',
    ];

    /**
     * 生成輸入格式
     * @param array $formInputOptions
     * @return array
     */
    public static function getFormInputs($formInputOptions = [])
    {
        $result = [];
        foreach ($formInputOptions as $formInputOption) {
            $setting = array_merge(self::formInputTemplate, $formInputOption);
            if (isset($formInputOption['inputAttrs'])) {
                $setting['inputAttrs'] = array_merge(self::inputAttrsTemplate, $formInputOption['inputAttrs']);
            }
            $setting['remark'] = isset($formInputOption['remark']) ? array_merge(self::remarkTemplate, $formInputOption['remark']) : self::remarkTemplate;
            $result[] = $setting;
        }
        return $result;
    }
}
