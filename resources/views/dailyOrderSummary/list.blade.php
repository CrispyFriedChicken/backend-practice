@extends('layouts.app')
@section('title' , '每日注單結算報表')
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
                'list' => \App\Models\GameType::getCodeTitleMap(true),
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

        [
            'type' => 'select',
            'class' => 'col-md-2',
            'inputAttrs' => [
                'title' => '排序欄位',
                'name' => 'sortColumn',
                'list' => [
                    'transactionDate' => '下注時間',
                    'totalWin' => '總贏分',
                    'bet' => '投注額',
                    'totalPayout' => '派彩',
                    'currency' => '幣別',
                ],
            ]
        ],
        [
            'type' => 'select',
            'class' => 'col-md-2 ',
            'inputAttrs' => [
                'title' => '排序規則',
                'name' => 'sortBy',
                'list' => [
                    'desc' => '降冪排序',
                    'asc' => '升冪排序',
                ],
            ]
        ],
    ]);
    $tableOptions = \App\Helper\TableOptionsHelper::getTableOptions([
        [
            'type' => 'text',
            'title' => '序',
            'name' => 'serial',
            'headerStyle' => 'width:40px;',
        ],
        [
            'type' => 'text',
            'title' => '報表日期',
            'name' => 'transactionDate',
        ],
        [
            'type' => 'text',
            'title' => '遊戲類型',
            'name' => 'type',
            'list' => \App\Models\GameType::getCodeTitleMap(true),
        ],
        [
            'type' => 'text',
            'title' => '幣別',
            'name' => 'currency',
            'list' => \App\Models\Currency::getCodeTitleMap(),
        ],
        [
            'type' => 'number',
            'title' => '總單量',
            'name' => 'orderCount',
        ],
        [
            'type' => 'money',
            'title' => '總贏分',
            'name' => 'totalWin',
        ],
        [
            'type' => 'money',
            'title' => '總投注',
            'name' => 'bet',
        ],
        [
            'type' => 'money',
            'title' => '總派彩',
            'name' => 'totalPayout',
        ],
        [
            'type' => 'link',
            'title' => '動作',
            'text' => '下載',
            'class' => 'btn btn-sm btn-success',
            'name' => 'url',
        ],
    ]);

    $defaultFields = [
        'transactionDate' => date('Y-m-d', strtotime('yesterday')),
        'sortColumn' => 'currency',
        'sortBy' => 'desc',
    ];
    ?>
    <list-page :table-options='@json($tableOptions)' :form-inputs='@json($formInputs)'
               :default-fields='@json($defaultFields)' url="dailyOrderSummary">
    </list-page>
@endsection
