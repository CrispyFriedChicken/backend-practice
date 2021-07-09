@extends('layouts.app')
@section('title' , '新增遊戲')
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
    <create-page  :form-inputs='@json($formInputs)' url="games">
    </create-page>
@endsection
