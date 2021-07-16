@extends('layouts.app')
@section('title' , '注單查詢')
@section('content')
    <?
    $formInputs = \App\Helper\FormInputsHelper::getFormInputs([
        [
            'type' => 'text',
            'class' => 'col-md-2',
            'inputAttrs' => [
                'title' => '局號',
                'name' => 'roundSerial',
            ]
        ],
        [
            'type' => 'text',
            'class' => 'col-md-2',
            'inputAttrs' => [
                'title' => '注單編號',
                'name' => 'orderSerial',
            ]
        ],
        [
            'type' => 'text',
            'class' => 'col-md-2',
            'inputAttrs' => [
                'title' => '玩家帳號',
                'name' => 'email',
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
                'title' => '遊戲類型',
                'name' => 'type',
                'placeholder' => '全選',
                'list' => \App\Models\GameType::getCodeTitleMap(),
                'multiple' => true,
            ]
        ],
        [
            'type' => 'select2',
            'class' => 'col-md-2 pl-md-0',
            'inputAttrs' => [
                'title' => '幣別',
                'name' => 'currency',
                'placeholder' => '全選',
                'list' => \App\Models\Currency::getCodeTitleMap(),
                'multiple' => true,
            ]
        ],
        [
            'type' => 'date',
            'class' => 'col-md-5',
            'inputAttrs' => [
                'title' => '下注時間',
                'name' => 'transactionDate',
                'dateMode' => 'datetimeRange',
            ],
        ],
        [
            'type' => 'select',
            'class' => 'col-md-2',
            'inputAttrs' => [
                'title' => '排序欄位',
                'name' => 'sortColumn',
                'list' => [
                    'transactionDate' => '下注時間',
                    'stakeCny' => '投注額',
                    'winningCny' => '派彩',
                ],
            ]
        ],
        [
            'type' => 'select',
            'class' => 'col-md-2',
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
            'title' => '局號',
            'name' => 'roundSerial',
        ],
        [
            'type' => 'text',
            'title' => '注單編號',
            'name' => 'orderSerial',
        ],
        [
            'type' => 'text',
            'title' => '下注時間',
            'name' => 'transactionDate',
        ],
        [
            'type' => 'text',
            'title' => '遊戲名稱',
            'name' => 'code',
            'list' => \App\Enum\GamesEnum::getCodeTitleMap(),
        ],
        [
            'type' => 'text',
            'title' => '玩家帳號',
            'name' => 'email',
        ],
        [
            'type' => 'text',
            'title' => '幣別',
            'name' => 'currency',
            'list' => \App\Models\Currency::getCodeTitleMap(),
        ],
        [
            'type' => 'money',
            'title' => '投注額',
            'name' => 'stake',
        ],
        [
            'type' => 'money',
            'title' => '派彩',
            'name' => 'winning',
        ],
        [
            'type' => 'money',
            'title' => '投注額(人民幣)',
            'name' => 'stakeCny',
        ],
        [
            'type' => 'money',
            'title' => '派彩(人民幣)',
            'name' => 'winningCny',
        ],
    ]);
    $defaultFields = [
        'sortColumn' => 'transactionDate',
        'sortBy' => 'desc',
    ];
    ?>
    <list-page :table-options='@json($tableOptions)' :form-inputs='@json($formInputs)'
               :default-fields='@json($defaultFields)' url="orders"
               :is-show-summary="true">
    </list-page>
@endsection
