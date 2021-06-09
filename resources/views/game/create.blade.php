@extends('layouts.app')
@section('title' , '建立遊戲')
@section('content')
    <create-game :game-type-list=@json(\App\Enum\GameTypeEnum::getKeyValueMap())></create-game>
@endsection
