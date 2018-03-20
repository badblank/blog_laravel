<!doctype html>
<html>
<head>
    <meta charset="utf-8">

    @yield('info')

    <link href="{{asset('../resources/views/home/css/base.css')}}" rel="stylesheet">
    <link href="{{asset('../resources/views/home/css/index.css')}}" rel="stylesheet">
    <link href="{{asset('../resources/views/home/css/new.css')}}" rel="stylesheet">
    <link href="{{asset('../resources/views/home/css/style.css')}}" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="{{asset('../resources/views/home/js/modernizr.js')}}"></script>
    <![endif]-->
</head>
<body>
<header>
    <div id="logo"><a href="{{url('/')}}"></a></div>
    <nav class="topnav" id="topnav">
        @foreach($navs as $k=>$v)<a href="{{$v->nav_url}}"><span>{{$v->nav_name}}</span><span class="en">{{$v->nav_alias}}</span></a>@endforeach
    </nav>
    </nav>
</header>

@section('content')
    <h3>
        <p>最新<span>文章</span></p>
    </h3>
    <ul class="rank">
        @foreach($new as $n)
            <li><a href="{{url('article/'.$n->art_id)}}" title="{{$n->art_title}}" target="_blank">{{$n->art_title}}</a></li>
        @endforeach
    </ul>
    <h3 class="ph">
        <p>点击<span>排行</span></p>
    </h3>
    <ul class="paih">
        @foreach($hot as $k=>$h)
            @if($k<5)
            <li><a href="{{url('article/'.$h->art_id)}}" title="{{$h->art_title}}" target="_blank">{{$h->art_title}}</a></li>
            @endif
        @endforeach
    </ul>
@show

<footer>
    <p>Design by 后盾网 <a href="http://www.miitbeian.gov.cn/" target="_blank">http://www.houdunwang.com</a> <a href="/">网站统计</a></p>
</footer>
{{--<script src="{{asset('../resources/views/home/js/silder.js')}}"></script>--}}
</body>
</html>

