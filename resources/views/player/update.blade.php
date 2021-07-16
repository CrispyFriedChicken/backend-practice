@extends('layouts.app')
@section('title' , '更新玩家')
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
                'isRequired' => true,
            ]
        ],
        [
            'type' => 'select',
            'inputAttrs' => [
                'title' => '幣別',
                'name' => 'currency',
                'list' => \App\Models\Currency::getCodeTitleMap(),
            ]
        ],
    ]);
    ?>
    <update-page  :form-inputs='@json($formInputs)' url="players" uuid="{{request()->get('uuid')}}">
    </update-page>
@endsection
