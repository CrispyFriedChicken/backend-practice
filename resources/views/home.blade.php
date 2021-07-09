@extends('layouts.app')
@section('title' , '首頁')
@section('content')
    <?php
    $user = \Illuminate\Support\Facades\Auth::user();
    ?>
    歡迎回來，{{$user->name}}
@endsection
