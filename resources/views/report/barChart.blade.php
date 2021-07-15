@extends('layouts.app')
@section('title' , '報表分析(長條圖)')
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
            'type' => 'select',
            'class' => 'pl-md-0 col-md-2',
            'inputAttrs' => [
                'title' => '遊戲類型',
                'name' => 'type',
                'placeholder' => '全選',
                'list' => array_merge(\App\Enum\GameTypeEnum::getKeyValueMap()),
            ]
        ],
        [
            'type' => 'select',
            'class' => 'col-md-3',
            'inputAttrs' => [
                'title' => '遊戲名稱',
                'name' => 'code',
                'placeholder' => '全選',
                'list' => \App\Enum\GamesEnum::getCodeTitleMap(),
            ]
        ],
        [
            'type' => 'select',
            'class' => 'col-md-2',
            'inputAttrs' => [
                'title' => '幣別',
                'name' => 'currency',
                'placeholder' => '全選',
                'list' => \App\Enum\CurrencyEnum::getKeyValueMap(),
            ]
        ],
    ]);
    $defaultFields = [
        'transactionDate' => \App\Models\DailyOrderSummary::max('transactionDate'),
    ];
    ?>
    <report-page :form-inputs='@json($formInputs)' :default-fields='@json($defaultFields)' url="report/barChart">

    </report-page>
@endsection
