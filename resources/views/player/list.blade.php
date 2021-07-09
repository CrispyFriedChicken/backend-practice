@extends('layouts.app')
@section('title' , '玩家一覽')
@section('content')
    {{--    <list-player :currency-list=@json()></list-player>--}}
    <?php
    $formInputs = \App\Helper\FormInputsHelper::getFormInputs([
        [
            'type' => 'text',
            'class' => 'col-md-3',
            'inputAttrs' => [
                'title' => '玩家名稱',
                'name' => 'name',
            ]
        ],
        [
            'type' => 'text',
            'class' => 'col-md-3',
            'inputAttrs' => [
                'title' => '玩家帳號',
                'name' => 'email',
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
    $tableOptions = \App\Helper\TableOptionsHelper::getTableOptions([
        [
            'type' => 'text',
            'title' => '序',
            'name' => 'serial',
            'headerStyle' => 'width:40px;',
        ],
        [
            'type' => 'text',
            'title' => '玩家名稱',
            'name' => 'name',
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
            'list' => \App\Enum\CurrencyEnum::getKeyValueMap(),
        ],
        [
            'type' => 'action',
            'title' => '動作',
            'name' => 'type',
            'buttons' => ['編輯', '刪除'],
            'headerStyle' => 'width:110px;',
        ],
    ]);
    //    //fixme 用完記得移除掉
    //    \App\Helper\OrderHelper::generateDailySummary();
    //    exit;
    ?>
    <list-page :table-options='@json($tableOptions)' :form-inputs='@json($formInputs)' url="players">
        <template v-slot:default="slotProps">
            @{{ slotProps['slotData']['test5566']}}
        </template>
    </list-page>
@endsection