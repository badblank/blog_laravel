<?php

namespace App\Http\Controllers\Home;

use App\Http\Models\Article;
use App\Http\Models\Category;
use App\Http\Models\Links;
use App\Http\Models\Navs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class IndexController extends Controller
{
    public function __construct()
    {
        $navs = Navs::orderBy('nav_order')->get();

        //点击量最高的6篇文章
        $hot  = Article::orderBy('art_view','desc')->take(6)->get();
        //8条最新文章
        $new = Article::orderBy('art_time','desc')->take(8)->get();

        View::share('navs',$navs);//分配给所有视图页面 参数共享
        View::share('hot',$hot);
        View::share('new',$new);
    }
    //首页
    public function index()
    {


        //图文列表（带分页）
        $data = Article::orderBy('art_time','desc')->paginate(5);

        //友情链接
        $link = Links::orderBy('link_order','asc')->get();

        //网站配置项

        return view('home.index',compact('data','link'));
    }

    //列表页
    public function cate($cate_id)
    {
        //查看次数自增
        Category::where('cate_id',$cate_id)->increment('cate_view');

        $field = Category::find($cate_id);

        //当前分类的子分类
        $submenu = Category::where('cate_pid',$cate_id)->get();

        //图文列表4篇（带分页）
        $data = Article::where('cate_id',$cate_id)->orderBy('art_time','desc')->paginate(4);
        return view('home.list',compact('data','field','submenu'));
    }

    //文章页
    public function article($art_id)
    {
        //查看次数自增
        Article::where('art_id',$art_id)->increment('art_view');

        $data = Article::find($art_id);

        $article['pre'] = Article::where('art_id','<',$art_id)->orderBy('art_id','desc')->first();
        $article['next'] = Article::where('art_id','>',$art_id)->orderBy('art_id','asc')->first();

        $about = Article::where('cate_id',$data->cate_id)->orderBy('art_id','desc')->take(6)->get();
        return view('home.new',compact('data','article','about'));
    }

}
