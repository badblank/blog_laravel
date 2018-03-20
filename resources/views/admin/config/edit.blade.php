@extends('layouts.admin')
@section('content')
    <!--面包屑配置项 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; <a href="{{url('admin/config')}}">配置项管理</a> &raquo; 编辑配置项
    </div>
    <!--面包屑配置项 结束-->

    <!--结果集标题与配置项组件 开始-->
    <div class="result_wrap">
        <div class="result_title">
            <h3>编辑配置项</h3>
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
                <a href="{{url('admin/config/create')}}"><i class="fa fa-plus"></i>添加配置项</a>
                <a href="{{url('admin/config')}}"><i class="fa fa-recycle"></i>全部配置项</a>
                {{-- <a href="#"><i class="fa fa-refresh"></i>更新排序</a>--}}
            </div>
        </div>
    </div>
    <!--结果集标题与配置项组件 结束-->

    <div class="result_wrap">
        <form action="{{url("admin/config/$field->conf_id")}}" method="post">
            <table class="add_tab">
                <tbody>
                <input type="hidden" name="_method" value="put">
                {{csrf_field()}}
{{--                <tr>
                    <th width="120"><i class="require">*</i>父级配置项：</th>
                    <td>
                        <select name="conf_pid">
                            <option value="0">==顶级配置项==</option>
                            @foreach($data as $d)
                                <option value="{{$d->conf_id}}"
                                @if($field->conf_pid == $d->conf_id)
                                    selected
                                @endif
                                >{{$d->conf_name}}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>--}}
                <tr>
                    <th><i class="require">*</i>标题：</th>
                    <td>
                        <input type="text" class="" name="conf_title" value="{{$field->conf_title}}">
                        <span><i class="fa fa-exclamation-circle yellow"></i>配置项标题不能为空</span>

                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>名称：</th>
                    <td>
                        <input type="text" class="" name="conf_name" value="{{$field->conf_name}}">
                        <span><i class="fa fa-exclamation-circle yellow"></i>配置项名称不能为空</span>

                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>类型：</th>
                    <td>
                        <input type="radio" name="field_type" value="input" onclick="showTr()" @if($field->field_type=="input") checked @endif>input &nbsp;&nbsp;
                        <input type="radio" name="field_type" value="radio" onclick="showTr()" @if($field->field_type=="radio") checked @endif>radio &nbsp;&nbsp;
                        <input type="radio" name="field_type" value="textarea" onclick="showTr()" @if($field->field_type=="textarea") checked @endif>textarea
                    </td>
                </tr>
                <tr class="field_value">
                    <th>类型值：</th>
                    <td>
                        <textarea type="text" class="" name="field_value">{{$field->field_value}}</textarea>
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>排序：</th>
                    <td>
                        <input type="text" class="sm" name="conf_order" value="{{$field->conf_order}}">

                    </td>
                </tr>
                <tr>
                    <th>说明：</th>
                    <td>
                        <textarea type="text" class="" name="conf_tips">{{$field->conf_tips}}</textarea>
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
    <script>
        showTr();
        function showTr(){
            var type = $('input[name=field_type]:checked').val();
            if(type=='radio'){
                $('.field_value').show();
            }else{
                $('.field_value').hide();
            }
        }
    </script>
@endsection