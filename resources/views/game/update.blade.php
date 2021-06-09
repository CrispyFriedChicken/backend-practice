@extends('layouts.app')
@section('title' , '更新遊戲')
@section('content')
    <update-game
        :game-type-list=@json(\App\Enum\GameTypeEnum::getKeyValueMap()) uuid="{{request()->get('uuid')}}"></update-game>
@endsection
