<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\Links;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class LinksController extends Controller
{
    //GET            admin/links         全部链接列表
    public function index()
    {
        //$links = (new links)->tree();//还可以把tree()方法变成静态
        $links= Links::orderBy('link_order','asc')->get();
        return view('admin.links.index')->with('data',$links);
    }

    //POST ajax更改排序
    public function changeOrder()
    {
        $input = Input::all();
        $link = Links::find($input['link_id']);
        $link->link_order = $input['link_order'];
        $re = $link->update();
        if($re){
            $data = [
                'status' => 0,
                'msg' => '链接排序更新成功!'
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '链接排序更新失败，请稍后重试!'
            ];
        }
        return $data;
    }

    //POST              admin/links  添加提交
    public function store()
    {
        $input = Input::except('_token');
        $rules = [
            'link_name'  => 'required',
            'link_title' => 'required',
            'link_order' => 'required',
        ];
        $messages = [
            'link_name.required'  => '链接名称不能为空！',
            'link_title.required' => '链接标题不能为空！',
            'link_order.required' => '链接排序不能为空！',
        ];

        $validator = Validator::make($input,$rules,$messages);
        if($validator->passes()){
            $re = links::create($input);
            if($re){
                return redirect('admin/links');
            }else{
                return back()->with('errors','链接添加有误，请稍后重试！');
            }
        }else{
            return back()->withErrors($validator);
        }

        dd(Input::all());
    }

    //GET|HEAD      admin/links/create   添加
    public function create()
    {
        return view('admin.links.add');
    }

    //GET|HEAD      admin/links/{links}
    public function show()
    {

    }

    //PUT|PATCH     admin/links/{links}   编辑提交
    public function update($link_id)
    {
        $input = Input::except('_token','_method');
        $re = links::where('link_id',$link_id)->update($input);
        if($re){
            return redirect('admin/links');
        }else{
            return back()->with('errors','链接信息更新失败，请稍后重试！');
        }
    }

    //DELETE        admin/links/{links}       删除单个链接
    public function destroy($link_id)
    {
        $re = links::where('link_id',$link_id)->delete();
        if($re){
            $data = [
                'status' => 0,
                'msg'    => '链接删除成功！'
            ];
        }else{
            $data = [
                'status' =>1,
                'msg'    => '链接删除失败，请稍后重试！'
            ];
        }
        return $data;
    }

    //GET|HEAD      admin/links/{links}/edit      编辑
    public function edit($link_id)
    {
        $field = links::find($link_id);
        return view('admin.links.edit',compact('field'));
    }
}
