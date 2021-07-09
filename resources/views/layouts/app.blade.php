<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>後台練習 - @yield('title')</title>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/menu.js') }}" defer></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') .'?v=1'}}" rel="stylesheet">
    <link href="{{ url("css/menu.css")}}" rel="stylesheet" type="text/css"/>
</head>
<body>
<div id="app">
    <div id="wrapper">
        <!-- Menu -->
        @include('layouts.menu')
        <div id="page-wrapper">
            <div class="container-fluid mt-5 mt-md-0 pl-0 pr-0">
                {{--訊息顯示--}}
                <div class="row mt-5 mt-md-0">
                    <div class="col-sm-12 col-md-12 mt-3 mt-md-0 pl-0 pr-0">
                        <flash message=""></flash>
                    </div>
                </div>
                {{--內容--}}
                <div class="row">
                    <div class="col-sm-12 col-md-12" id="content">
                        <div class="container-fluid">
                            <div class="offset-md-1 col-md-10 pr-0 pl-0">
                                <h1>@yield('title')</h1>
                                <div class="border rounded p-5">
                                    @yield('content')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
@stack('style')
@stack('script')
</html>
