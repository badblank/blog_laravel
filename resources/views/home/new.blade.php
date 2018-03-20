﻿@extends('layouts.home')
@section('info')
  <title>后盾个人博客</title>
  <meta name="keywords" content="个人博客模板,博客模板" />
  <meta name="description" content="寻梦主题的个人博客模板，优雅、稳重、大气,低调。" />
@endsection
@section('content')
  <article class="blogs">
    <h1 class="t_nav">
        <span>您当前的位置：<a href="/index.html">首页</a>&nbsp;&gt;&nbsp;<a href="/news/s/">慢生活</a>&nbsp;&gt;&nbsp;<a href="/news/s/">日记</a></span>

        <a href="/" class="n1">网站首页</a><a href="/" class="n2">日记</a>
    </h1>
    <div class="index_about">
      <h2 class="c_titile">{{$data->art_title}}</h2>
      <p class="box_c"><span class="d_time">发布时间：{{date('Y-m-d',$data->art_time)}}</span><span>编辑：{{$data->art_editor}}</span><span>查看次数：{{$data->art_view}}</span></p>
      <ul class="infos">
        {!! $data->art_content !!}
      </ul>
      <div class="keybq">
        <p><span>关键字词</span>：{{$data->art_tag}}</p>

      </div>
      <div class="ad"> </div>
      <div class="nextinfo">
        <p>上一篇：
            @if($article['pre'])
            <a href="{{url('article/'.$article['pre']->art_id)}}">{{$article['pre']->art_title}}</a>
            @else
                <span>没有上一篇了</span>
            @endif
        </p>
          <p>下一篇：
              @if($article['next'])
                  <a href="{{url('article/'.$article['next']->art_id)}}">{{$article['next']->art_title}}</a></p>
              @else
                  <span>没有上一篇了</span>
              @endif
              </p>
      </div>
      <div class="otherlink">
        <h2>相关文章</h2>
        <ul>
            @foreach($about as $a)
                <li><a href="{{url('article/'.$a->art_id)}}" title="{{$a->art_title}}">{{$a->art_title}}</a></li>
            @endforeach
        </ul>
      </div>
    </div>
    <aside class="right">
      <!-- Baidu Button BEGIN -->
      <div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare"><a class="bds_tsina"></a><a class="bds_qzone"></a><a class="bds_tqq"></a><a class="bds_renren"></a><span class="bds_more"></span><a class="shareCount"></a></div>
      <script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6574585" ></script>
      <script type="text/javascript" id="bdshell_js"></script>
      <script type="text/javascript">
          document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
      </script>
      <!-- Baidu Button END -->
      <div class="blank"></div>
      <div class="news">
          @parent
      </div>
      <div class="visitors">
        <h3>
          <p>最近访客</p>
        </h3>
        <ul>
        </ul>
      </div>
    </aside>
  </article>
@endsection