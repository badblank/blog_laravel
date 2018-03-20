<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\Navs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class NavsController extends Controller
{
    //GET            admin/navs         全部导航列表
    public function index()
    {
        //$navs = (new navs)->tree();//还可以把tree()方法变成静态
        $navs= Navs::orderBy('nav_order','asc')->get();
        return view('admin.navs.index')->with('data',$navs);
    }

    //POST ajax更改排序
    public function changeOrder()
    {
        $input = Input::all();
        $nav = navs::find($input['nav_id']);
        $nav->nav_order = $input['nav_order'];
        $re = $nav->update();
        if($re){
            $data = [
                'status' => 0,
                'msg' => '导航排序更新成功!'
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '导航排序更新失败，请稍后重试!'
            ];
        }
        return $data;
    }

    //POST              admin/navs  添加提交
    public function store()
    {
        $input = Input::except('_token');
        $rules = [
            'nav_name'  => 'required',
            'nav_alias' => 'required',
            'nav_order' => 'required',
        ];
        $messages = [
            'nav_name.required'  => '导航名称不能为空！',
            'nav_title.required' => '导航别名不能为空！',
            'nav_order.required' => '导航排序不能为空！',
        ];

        $validator = Validator::make($input,$rules,$messages);
        if($validator->passes()){
            $re = navs::create($input);
            if($re){
                return redirect('admin/navs');
            }else{
                return back()->with('errors','导航添加有误，请稍后重试！');
            }
        }else{
            return back()->withErrors($validator);
        }

        dd(Input::all());
    }

    //GET|HEAD      admin/navs/create   添加
    public function create()
    {
        return view('admin.navs.add');
    }

    //GET|HEAD      admin/navs/{navs}
    public function show()
    {

    }

    //PUT|PATCH     admin/navs/{navs}   编辑提交
    public function update($nav_id)
    {
        $input = Input::except('_token','_method');
        $re = navs::where('nav_id',$nav_id)->update($input);
        if($re){
            return redirect('admin/navs');
        }else{
            return back()->with('errors','导航信息更新失败，请稍后重试！');
        }
    }

    //GET|HEAD      admin/navs/{navs}/edit      编辑
    public function edit($nav_id)
    {
        $field = navs::find($nav_id);
        return view('admin.navs.edit',compact('field'));
    }

    //DELETE        admin/navs/{navs}       删除单个导航
    public function destroy($nav_id)
    {
        $re = navs::where('nav_id',$nav_id)->delete();
        if($re){
            $data = [
                'status' => 0,
                'msg'    => '导航删除成功！'
            ];
        }else{
            $data = [
                'status' =>1,
                'msg'    => '导航删除失败，请稍后重试！'
            ];
        }
        return $data;
    }


}
