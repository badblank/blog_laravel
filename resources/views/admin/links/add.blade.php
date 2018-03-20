@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; <a href="{{url('admin/links')}}">友情链接管理</a> &raquo; 添加友情链接
    </div>
    <!--面包屑导航 结束-->

    <!--结果集标题与导航组件 开始-->
    <div class="result_wrap">
        <div class="result_title">
            <h3>添加友情链接</h3>
            @if(count($errors)>0)
                <div class="mark">
                    @if(is_string($errors))
                        <p>{{$errors}}</p>
                    @else
                        @foreach($errors->all() as $error)
                            <p>{{$error}}</p>
                        @endforeach
                    @endif
                </div>
            @endif
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/links/create')}}"><i class="fa fa-plus"></i>添加友情链接</a>
                <a href="{{url('admin/links')}}"><i class="fa fa-recycle"></i>全部友情链接</a>
                {{-- <a href="#"><i class="fa fa-refresh"></i>更新排序</a>--}}
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->

    <div class="result_wrap">
        <form action="{{url("admin/links")}}" method="post">
            <table class="add_tab">
                <tbody>
                {{csrf_field()}}
{{--                <tr>
                    <th width="120"><i class="require">*</i>父级友情链接：</th>
                    <td>
                        <select name="link_pid">
                            <option value="0">==顶级友情链接==</option>
                            @foreach($data as $d)
                                <option value="{{$d->link_id}}">{{$d->link_name}}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>--}}
                <tr>
                    <th><i class="require">*</i>友情链接名称：</th>
                    <td>
                        <input type="text" class="" name="link_name">

                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>友情链接标题：</th>
                    <td>
                        <input type="text" class="lg" name="link_title">
                        <p>标题可以写30个字</p>
                    </td>
                </tr>
                <tr>
                    <th>友情链接地址：</th>
                    <td>
                        <input type="text" class="lg" name="link_url">
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>排序：</th>
                    <td>
                        <input type="text" class="sm" name="link_order">

                    </td>
                </tr>
                <tr>
                    <th></th>
                    <td>
                        <input type="submit" value="提交">
                        <input type="button" class="back" onclick="history.go(-1)" value="返回">
                    </td>
                </tr>
                </tbody>
            </table>
        </form>
    </div>
@endsection