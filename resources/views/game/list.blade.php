@extends('layouts.app')
@section('title' , '遊戲列表')
@section('content')
    <list-game :game-type-list=@json(\App\Enum\GameTypeEnum::getKeyValueMap())></list-game>
@endsection
