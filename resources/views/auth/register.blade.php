<?php

use Illuminate\Support\Facades\URL;

?>
@extends('layouts.app')
@section('title' , '註冊')
@section('content')
    {{Form::open([
        'method' => 'POST',
        'url' => 'register',
    ])}}
    @csrf
    {{--姓名--}}
    <div class="form-group row">
        {{Form::label('' , '姓名' , [
            'for' => 'name',
            'class' => 'col-md-4 col-form-label text-md-right',
        ])}}
        <div class="col-md-6">
            {{Form::text('name' , old('name') ,[
                  'id' => 'name',
                  'class' => 'form-control'. ($errors->has('name') ? ' is-invalid' : null),
                  'required' => 'required',
                  'autofocus' => 'autofocus',
                  'autocomplete' => 'name',
            ])}}
            @error('name')
            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
            @enderror
        </div>
    </div>
    {{--Email(帳號)--}}
    <div class="form-group row">
        {{Form::label('' , 'Email(帳號)' , [
            'for' => 'email',
            'class' => 'col-md-4 col-form-label text-md-right',
        ])}}
        <div class="col-md-6">
            {{Form::email('email' , old('email') ,[
                'id' => 'email',
                'class' => 'form-control'. ($errors->has('email') ? ' is-invalid' : null),
                'required' => 'required',
                'autocomplete' => 'email',
            ])}}
            @error('email')
            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
            @enderror
        </div>
    </div>
    {{--密碼--}}
    <div class="form-group row">
        {{Form::label('','密碼',[
            'for' => 'password',
            'class' => 'col-md-4 col-form-label text-md-right',
        ])}}
        <div class="col-md-6">
            {{Form::password('password' ,[
                'id' => 'password',
                'class' => 'form-control'. ($errors->has('password') ? ' is-invalid' : null),
                'required' => 'required',
                'autocomplete' => 'new-password',
            ])}}
            @error('password')
            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
            @enderror
        </div>
    </div>
    {{--密碼確認--}}
    <div class="form-group row">
        {{Form::label('','密碼確認',[
            'for' => 'password-confirm',
            'class' => 'col-md-4 col-form-label text-md-right',
        ])}}
        <div class="col-md-6">
            {{Form::password('password_confirmation' ,[
                'id' => 'password-confirm',
                'class' => 'form-control',
                'required' => 'required',
                'autocomplete' => 'new-password',
            ])}}
        </div>
    </div>
    {{--註冊(送出)--}}
    <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-4">
            {{Form::submit('註冊',[
                'class'=>'btn btn-primary'
            ])}}
        </div>
    </div>
    {{Form::close()}}
@endsection
