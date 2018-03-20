<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    //GET            admin/category         全部分类列表
    public function index()
    {
        $categorys = (new Category)->tree();//还可以把tree()方法变成静态
        return view('admin.category.index')->with('data',$categorys);
    }

    //POST ajax更改排序
    public function changeOrder()
    {
        $input = Input::all();
        $cate = Category::find($input['cate_id']);
        $cate->cate_order = $input['cate_order'];
        $re = $cate->update();
        if($re){
            $data = [
                'status' => 0,
                'msg' => '分类排序更新成功!'
            ];
        }else{
            $data = [
                'status' => 1,
                'msg' => '分类排序更新失败，请稍后重试!'
            ];
        }
        return $data;
    }
    
    //POST              admin/category  添加提交
    public function store()
    {
        $input = Input::except('_token');
        $rules = [
            'cate_name'  => 'required',
            'cate_title' => 'required',
            'cate_order' => 'required',
        ];
        $messages = [
            'cate_name.required'  => '分类名称不能为空！',
            'cate_title.required' => '分类标题不能为空！',
            'cate_order.required' => '分类排序不能为空！',
        ];

        $validator = Validator::make($input,$rules,$messages);
        if($validator->passes()){
            $re = Category::create($input);
            if($re){
                return redirect('admin/category');
            }else{
                return back()->with('errors','分类添加有误，请稍后重试！');
            }
        }else{
            return back()->withErrors($validator);
        }

        dd(Input::all());
    }

    //GET|HEAD      admin/category/create   添加
    public function create()
    {
        $data = Category::where('cate_pid',0)->get();
        return view('admin.category.add',compact('data'));
    }

    //GET|HEAD      admin/category/{category}
    public function show()
    {
        
    }

    //PUT|PATCH     admin/category/{category}   编辑提交
    public function update($cate_id)
    {
        $input = Input::except('_token','_method');
        $re = Category::where('cate_id',$cate_id)->update($input);
        if($re){
            return redirect('admin/category');
        }else{
            return back()->with('errors','分类信息更新失败，请稍后重试！');
        }
    }

    //DELETE        admin/category/{category}       删除单个分类
    public function destroy($cate_id)
    {
        $re = Category::where('cate_id',$cate_id)->delete();
        Category::where('cate_pid',$cate_id)->update(['cate_pid'=>0]);
        if($re){
            $data = [
                'status' => 0,
                'msg'    => '分类删除成功！'
            ];
        }else{
            $data = [
                'status' =>1,
                'msg'    => '分类删除失败，请稍后重试！'
            ];
        }
        return $data;
    }

    //GET|HEAD      admin/category/{category}/edit      编辑
    public function edit($cate_id)
    {
        $data = Category::where('cate_pid',0)->get();
        $field = Category::find($cate_id);
        return view('admin.category.edit',compact('data','field'));
    }
}
