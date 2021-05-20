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

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') .'?v=1'}}" rel="stylesheet">

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
</head>
<style>
    @import url('https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css');

    @media (min-width: 768px) {
        body {
            margin-top: 50px;
        }

        /*html, body, #wrapper, #page-wrapper {height: 100%; overflow: hidden;}*/
    }

    #wrapper {
        padding-left: 0;
    }

    #page-wrapper {
        width: 100%;
        padding: 0;
        background-color: #fff;
    }

    .collapse.show {
        visibility: visible;
    }

    @media (min-width: 768px) {
        #wrapper {
            padding-left: 225px;
        }

        #page-wrapper {
            padding: 22px 10px;
        }
    }

    /* Top Navigation */

    .top-nav {
        padding: 0 15px;
    }

    .top-nav > li {
        display: inline-block;
        float: left;
    }

    .top-nav > li > a {
        padding-top: 20px;
        padding-bottom: 20px;
        line-height: 20px;
        color: #fff;
    }

    .top-nav > li > a:hover,
    .top-nav > li > a:focus,
    .top-nav > .open > a,
    .top-nav > .open > a:hover,
    .top-nav > .open > a:focus {
        color: #fff;
        background-color: #1a242f;
    }

    .top-nav > .open > .dropdown-menu {
        float: left;
        position: absolute;
        margin-top: 0;
        /*border: 1px solid rgba(0,0,0,.15);*/
        border-top-left-radius: 0;
        border-top-right-radius: 0;
        background-color: #fff;
        -webkit-box-shadow: 0 6px 12px rgba(0, 0, 0, .175);
        box-shadow: 0 6px 12px rgba(0, 0, 0, .175);
    }

    .top-nav > .open > .dropdown-menu > li > a {
        white-space: normal;
    }

    /* Side Navigation */

    @media (min-width: 768px) {
        .side-nav {
            position: fixed;
            top: 60px;
            left: 225px;
            width: 225px;
            margin-left: -225px;
            border: none;
            border-radius: 0;
            border-top: 1px rgba(0, 0, 0, .5) solid;
            overflow-y: auto;
            background-color: #222;
            /*background-color: #5A6B7D;*/
            bottom: 0;
            overflow-x: hidden;
            padding-bottom: 40px;
        }

        .side-nav > li > a {
            width: 225px;
            border-bottom: 1px rgba(0, 0, 0, .3) solid;
        }

        .side-nav li a:hover,
        .side-nav li a:focus {
            outline: none;
            background-color: #1a242f !important;
        }
    }

    .side-nav > li > ul {
        padding: 0;
        border-bottom: 1px rgba(0, 0, 0, .3) solid;
    }

    .side-nav > li > ul > li > a {
        display: block;
        padding: 10px 15px 10px 38px;
        text-decoration: none;
        /*color: #999;*/
        color: #fff;
    }

    .side-nav > li > ul > li > a:hover {
        color: #fff;
    }

    .navbar .nav > li > a > .label {
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        border-radius: 50%;
        position: absolute;
        top: 14px;
        right: 6px;
        font-size: 10px;
        font-weight: normal;
        min-width: 15px;
        min-height: 15px;
        line-height: 1.0em;
        text-align: center;
        padding: 2px;
    }

    .navbar .nav > li > a:hover > .label {
        top: 10px;
    }

    .navbar-brand {
        padding: 5px 15px;
    }
</style>
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
        $(".side-nav .collapse").on("hide.bs.collapse", function () {
            $(this).prev().find(".fa").eq(1).removeClass("fa-angle-right").addClass("fa-angle-down");
        });
        $('.side-nav .collapse').on("show.bs.collapse", function () {
            $(this).prev().find(".fa").eq(1).removeClass("fa-angle-down").addClass("fa-angle-right");
        });
    })
</script>
<body>
<div id="throbber" style="display:none; min-height:120px;"></div>
<div id="noty-holder"></div>
<div id="wrapper">
    <!-- Menu -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" style="display: block;">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header mb-3">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            {{--logo--}}
            {{Html::link(
                '/',
                Html::image('img/logo.png'),
                [
                    'class'=>'navbar-brand',
                ],
                null,
                false
            )}}
        </div>
        <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav side-nav mt-3">
                <?php
                $menuList = \App\Helper\CommonHelper::getMenuList();
                ?>
                @foreach($menuList as $firstLayer)
                    <li>
                        @if(count($firstLayer['subItems']))
                            {{--兩層--}}

                            {{--第一層--}}
                            {{Html::link(
                                $firstLayer['url'] ? url($firstLayer['url']) : '#',
                                $firstLayer['content'].' <i class="fa fa-fw fa-angle-down pull-right"></i>',
                                [
                                    'data-toggle'=>'collapse',
                                    'data-target'=>'#'.$firstLayer['id'],
                                ],
                                null,
                                false
                            )}}
                            <ul id="{{$firstLayer['id']}}" class="collapse">
                                {{--第二層--}}
                                @foreach($firstLayer['subItems'] as $subItem)
                                    <li>
                                        {{Html::link(
                                            $subItem['url'] ? url($subItem['url']) : '#',
                                            '<i class="fa fa-angle-double-right"></i> '.$subItem['content'],
                                            [],
                                            null,
                                            false
                                        )}}
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            {{--單層--}}
                            {{Html::link(
                                $firstLayer['url'] ? url($firstLayer['url']) : '#',
                                $firstLayer['content'],
                                $firstLayer['option'],
                                null,
                                false
                            )}}
                        @endif
                    </li>
                @endforeach
            </ul>
            {{Form::open([
                'id' => 'logout-form',
                'method' => 'POST',
                'url' => 'logout',
            ])}}
            {{Form::close()}}
        </div>
        <!-- /.navbar-collapse -->
    </nav>
    {{--內容--}}
    <div id="page-wrapper">
        <div class="container-fluid mt-5">
            <!-- Page Heading -->
            <div class="row  mt-5">
                <div class="col-sm-12 col-md-12 mt-5" id="content">
                    @yield('content')
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
</div><!-- /#wrapper -->
</body>

@stack('style')
@stack('script')
</html>
