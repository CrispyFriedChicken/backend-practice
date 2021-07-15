@extends('layouts.app')
@section('title' , '遊戲一覽')
@section('content')
    <?php
    $formInputs = \App\Helper\FormInputsHelper::getFormInputs([
        [
            'type' => 'text',
            'class' => 'col-md-2',
            'inputAttrs' => [
                'title' => '中文名稱',
                'name' => 'chineseName',
            ]
        ],
        [
            'type' => 'text',
            'class' => 'col-md-2',
            'inputAttrs' => [
                'title' => '英文名稱',
                'name' => 'englishName',
            ]
        ],
        [
            'type' => 'text',
            'class' => 'col-md-2',
            'inputAttrs' => [
                'title' => '遊戲代號',
                'name' => 'code',
            ]
        ],
        [
            'type' => 'select2',
            'class' => 'col-md-2',
            'inputAttrs' => [
                'title' => '遊戲類型',
                'name' => 'type',
                'placeholder' => '全選',
                'list' => \App\Enum\GameTypeEnum::getKeyValueMap(),
                'multiple' => true,
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
            'title' => '中文名稱',
            'name' => 'chineseName',
        ],
        [
            'type' => 'text',
            'title' => '英文名稱',
            'name' => 'englishName',
        ],
        [
            'type' => 'text',
            'title' => '遊戲代號',
            'name' => 'code',
        ],
        [
            'type' => 'text',
            'title' => '遊戲類型',
            'name' => 'type',
            'list' => \App\Enum\GameTypeEnum::getKeyValueMap(),
        ],
        [
            'type' => 'action',
            'title' => '動作',
            'name' => 'type',
            'buttons' => ['編輯', '刪除'],
            'headerStyle' => 'width:110px;',
        ],
    ]);
    ?>
    <list-page :table-options='@json($tableOptions)' :form-inputs='@json($formInputs)' url="games">
    </list-page>
@endsection
