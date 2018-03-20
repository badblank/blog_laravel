<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\Article;
use App\Http\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    //GET            admin/article         全部分类列表
    public function index()
    {
        $data = Article::orderBy('art_id','desc')->paginate(10);
        return view('admin.article.index')->with('data',$data);
    }


    //POST              admin/article  添加提交
    public function store()
    {
        $input = Input::except('_token');
        $input['art_time'] = time();
        $rules = [
            'art_title' => 'required',
            'art_content' => 'required',
        ];
        $message = [
            'art_title.required' => '文章标题不能为空',
            'art_content.required' => '文章内容不能为空'
        ];

        $validator = Validator::make($input,$rules,$message);
        if($validator->passes()){
            $re = Article::create($input);
            if($re){
                return redirect('admin/article');
            }else{
                return back()->with('errors','文章添加有误，请稍后重试！');
            }
        }else{
            return back()->withErrors($validator);
        }
    }

    //GET|HEAD      admin/article/create   添加
    public function create()
    {
        $categorys = (new Category)->tree();//还可以把tree()方法变成静态
        return view('admin.article.add')->with('data',$categorys);
    }

    //GET|HEAD      admin/article/{article}
    public function show()
    {

    }

    //PUT|PATCH     admin/article/{article}   编辑提交
    public function update($art_id)
    {
        $input = Input::except('_token','_method');
        $re = Article::where('art_id',$art_id)->update($input);
        if($re){
            return redirect('admin/article');
        }else{
            return back()->with('errors','文章信息更新失败，请稍后重试！');
        }

    }

    //DELETE        admin/article/{article}       删除单个分类
    public function destroy($art_id)
    {
        $re = Article::where('art_id',$art_id)->delete();
        if($re){
            $data = [
                'status' => 0,
                'msg'    => '文章删除成功！'
            ];
        }else{
            $data = [
                'status' =>1,
                'msg'    => '文章删除失败，请稍后重试！'
            ];
        }
        return $data;
    }

    //GET|HEAD      admin/article/{article}/edit      编辑
    public function edit($art_id)
    {
        $data = (new Category)->tree();//还可以把tree()方法变成静态
        $field = Article::find($art_id);
        return view('admin.article.edit',compact('data','field'));
    }
}
