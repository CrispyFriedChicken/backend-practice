@extends('layouts.app')
@section('title' , '更新遊戲')
@section('content')
    <?php
    $formInputs = \App\Helper\FormInputsHelper::getFormInputs([
        [
            'type' => 'text',
            'inputAttrs' => [
                'title' => '中文名稱',
                'name' => 'chineseName',
                'isRequired' => true,
            ]
        ],
        [
            'type' => 'text',
            'inputAttrs' => [
                'title' => '英文名稱',
                'name' => 'englishName',
                'isRequired' => true,
            ]
        ],
        [
            'type' => 'value',
            'remark' => [
                'content' => '此代號由系統自動產生，若更改遊戲類型並更新，系統會產生新單號！',
            ],
            'inputAttrs' => [
                'title' => '遊戲代號',
                'name' => 'code',
                'isRequired' => true,
            ],
        ],
        [
            'type' => 'select',
            'inputAttrs' => [
                'title' => '遊戲類型',
                'name' => 'type',
                'placeholder' => '全選',
                'list' => \App\Enum\GameTypeEnum::getKeyValueMap(),
            ]
        ],
    ]);
    ?>
    <update-page :form-inputs='@json($formInputs)' url="games" uuid="{{request()->get('uuid')}}">
    </update-page>
@endsection
