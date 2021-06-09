@extends('layouts.app')
@section('title' , '登入')

@section('content')
    <div>
        {{Form::open([
               'method' => 'POST',
               'url' => 'login',
       ])}}
        @csrf

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
                    'autofocus' => 'autofocus',
                ])}}
                @error('email')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
        </div>

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
                    'autocomplete' => 'current-password',
                ])}}
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-6 offset-md-4">
                <div class="form-check">
                    {{Form::label(
                        '',
                        '記住'.Form::checkbox('remember' , 1 , old('remember') ? 'checked' : '' ,['id' => 'remember','class' => 'form-check-input']),
                        [
                            'for' => 'remember',
                            'class' => 'form-check-label mr-3',
                        ],
                        false
                    )}}
                </div>
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-8 offset-md-4">
                {{Form::submit('登入',[
                    'class'=>'btn btn-primary'
                ])}}
                @if (Route::has('password.request'))
                    {{Html::link(
                        route('password.request'),
                        '忘記密碼?',
                        ['class' => 'btn btn-link'],
                        null,
                        false
                    )}}
                @endif
            </div>
        </div>
        {{Form::close()}}
    </div>
@endsection
