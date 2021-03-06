@extends('layouts.app')
@section('title' , '玩家排行')
@section('content')
    <?php
    $formInputs = \App\Helper\FormInputsHelper::getFormInputs([
        [
            'type' => 'date',
            'class' => 'col-md-12',
            'inputAttrs' => [
                'title' => '下注時間',
                'name' => 'transactionDate',
                'dateMode' => 'date',
            ],
        ],
        [
            'type' => 'select2',
            'class' => 'pl-md-0 col-md-2',
            'inputAttrs' => [
                'title' => '遊戲類型',
                'name' => 'type',
                'placeholder' => '全選',
                'list' => \App\Models\GameType::getCodeTitleMap(),
                'multiple' => true,
            ]
        ],
        [
            'type' => 'select2',
            'class' => 'col-md-3',
            'inputAttrs' => [
                'title' => '遊戲名稱',
                'name' => 'code',
                'placeholder' => '全選',
                'list' => \App\Enum\GamesEnum::getCodeTitleMap(),
                'multiple' => true,
            ]
        ],
        [
            'type' => 'select2',
            'class' => 'col-md-2',
            'inputAttrs' => [
                'title' => '幣別',
                'name' => 'currency',
                'placeholder' => '全選',
                'list' => \App\Models\Currency::getCodeTitleMap(),
                'multiple' => true,
            ]
        ],
    ]);
    $defaultFields = [
        'transactionDate' => date('Y-m-d'),
    ];
    $remark = [
        'content' => '目前頁面上顯示的金額幣別皆為人民幣(其他幣別會以注單生成時的匯率換算成人民幣)',
        'class' => 'ml-0 alert alert-warning',
    ];
    ?>
    <report-page :form-inputs='@json($formInputs)' :default-fields='@json($defaultFields)' url="report/playerRank" :remark='@json($remark,1)'>

    </report-page>
@endsection
