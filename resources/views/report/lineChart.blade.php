@extends('layouts.app')
@section('title' , '報表分析(折線圖)')
@section('content')
    <?php
    $formInputs = \App\Helper\FormInputsHelper::getFormInputs([
        [
            'type' => 'date',
            'class' => 'col-md-12',
            'inputAttrs' => [
                'title' => '下注時間',
                'name' => 'transactionDate',
                'dateMode' => 'dateRange',
            ],
        ],
        [
            'type' => 'select2',
            'class' => 'pl-md-0 col-md-2',
            'inputAttrs' => [
                'title' => '遊戲類型',
                'name' => 'type',
                'placeholder' => '全選',
                'list' => array_merge(\App\Enum\GameTypeEnum::getKeyValueMap()),
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
                'list' => \App\Enum\CurrencyEnum::getKeyValueMap(),
                'multiple' => true,
            ]
        ],
    ]);

    $dateEnd = \App\Models\DailyOrderSummary::max('transactionDate');
    $dateStart = date('Y-m-d', strtotime($dateEnd . ' -7day'));
    $defaultFields = [
        'transactionDate' => [$dateStart, $dateEnd],
    ];
    ?>
    <report-page :form-inputs='@json($formInputs)' :default-fields='@json($defaultFields)' url="report/lineChart">

    </report-page>
@endsection
