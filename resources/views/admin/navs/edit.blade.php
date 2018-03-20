@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; <a href="{{url('admin/navs')}}">导航管理</a> &raquo; 编辑导航
    </div>
    <!--面包屑导航 结束-->

    <!--结果集标题与导航组件 开始-->
    <div class="result_wrap">
        <div class="result_title">
            <h3>编辑导航</h3>
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
                <a href="{{url('admin/navs/create')}}"><i class="fa fa-plus"></i>添加导航</a>
                <a href="{{url('admin/navs')}}"><i class="fa fa-recycle"></i>全部导航</a>
                {{-- <a href="#"><i class="fa fa-refresh"></i>更新排序</a>--}}
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->

    <div class="result_wrap">
        <form action="{{url("admin/navs/$field->nav_id")}}" method="post">
            <table class="add_tab">
                <tbody>
                <input type="hidden" name="_method" value="put">
                {{csrf_field()}}
{{--                <tr>
                    <th width="120"><i class="require">*</i>父级导航：</th>
                    <td>
                        <select name="nav_pid">
                            <option value="0">==顶级导航==</option>
                            @foreach($data as $d)
                                <option value="{{$d->nav_id}}"
                                @if($field->nav_pid == $d->nav_id)
                                    selected
                                @endif
                                >{{$d->nav_name}}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>--}}
                <tr>
                    <th><i class="require">*</i>导航名称：</th>
                    <td>
                        <input type="text" class="" name="nav_name" value="{{$field->nav_name}}">
                        <input type="text" class="" name="nav_alias" value="{{$field->nav_name}}">

                    </td>
                </tr>
                <tr>
                    <th>导航地址：</th>
                    <td>
                        <input type="text" class="lg" name="nav_url" value="{{$field->nav_url}}">
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>排序：</th>
                    <td>
                        <input type="text" class="sm" name="nav_order" value="{{$field->nav_order}}">

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