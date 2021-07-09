<?php
use App\Helper\MenuHelper;
?>
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
            $menuList = MenuHelper::getMenuList();
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
                        <ul id="{{$firstLayer['id']}}"
                            class="{{MenuHelper::checkIsFirstLayerActive($firstLayer) ? 'collapse in show' : 'collapse'}}"
                            {{MenuHelper::checkIsFirstLayerActive($firstLayer) ? 'aria-expanded="true"' : ''}}>
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
