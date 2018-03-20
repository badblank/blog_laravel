<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;

require_once "../resources/org/code/Code.class.php";
class LoginController extends Controller
{
    //登录
    public function login()
    {
        if($input = Input::all()){
            $code = (new \Code());
            $_code = $code->get();
            if(strtoupper($input['code']) != $_code ){
                return back()->with('msg','验证码错误！');
            }
            $user = User::first();
            if( $user->user_name != $input['username'] || Crypt::decrypt($user->user_pass) != $input['password']){
                return back()->with('msg','用户名或者密码错误！');
            }
            session(['user'=>$user]);
            return redirect('admin/index');
        }else{
            return view('admin.login');
        }

    }

    //验证码
    public function code()
    {
        $code = new \Code();
        $code->make();
    }

    public function getcode()
    {
        dd($_SERVER);
        $str = "123456";
        echo Crypt::encrypt($str);
    }

    //后台主页面
    public function index()
    {
        return view('admin.index');
    }
}
