@extends('layouts.app')
@section('title' , '新增玩家')
@section('content')
    <?php
    $formInputs = \App\Helper\FormInputsHelper::getFormInputs([
        [
            'type' => 'text',
            'inputAttrs' => [
                'title' => '玩家名稱',
                'name' => 'name',
                'isRequired' => true,
            ]
        ],
        [
            'type' => 'text',
            'inputAttrs' => [
                'title' => '玩家信箱',
                'name' => 'email',
                'type' => 'email',
                'isRequired' => true,
            ]
        ],
        [
            'type' => 'text',
            'inputAttrs' => [
                'title' => '密碼',
                'name' => 'password',
                'type' => 'password',
                'isRequired' => true,
            ]
        ],
        [
            'type' => 'text',
            'inputAttrs' => [
                'title' => '確認密碼',
                'name' => 'password_confirmation',
                'type' => 'password',
                'isRequired' => true,
            ]
        ],
        [
            'type' => 'select',
            'inputAttrs' => [
                'title' => '幣別',
                'name' => 'currency',
                'list' => \App\Enum\CurrencyEnum::getKeyValueMap(),
                'isRequired' => true,
            ]
        ],
    ]);
    ?>
    <create-page :form-inputs='@json($formInputs)' url="players">
    </create-page>
@endsection
