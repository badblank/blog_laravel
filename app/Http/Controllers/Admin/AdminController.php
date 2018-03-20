<?php

namespace App\Http\Controllers\Admin;

use App\Http\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    //后台首页
    public function index()
    {
        return view('admin.index');
    }

    //系统信息
    public function info(){
        return view('admin.info');
    }

    //退出
    public function quit(){
        session(['user'=>null]);
        return redirect('admin/login');
    }

    //修改密码
    public function pass()
    {
        if($input= Input::all()){
            $rules = [
                'password' => 'required|between:6,20|confirmed',
            ];
            $message = [
                'password.required' => '新密码不能为空！',
                'password.between' =>'新密码必须在6-20位之间！',
                'password.confirmed' =>'两次输入密码不一致！'
            ];
            $validator = Validator::make($input,$rules,$message);

            if($validator->passes()){
                $user = User::first();
                $_password = Crypt::decrypt($user->user_pass);
                if($input['password_o']==$_password){
                    $user->user_pass = Crypt::encrypt($input['password']);
                    $user->update();
                    return redirect('admin/info');
                }else{
                    return back()->with("errors","原密码错误！");
                }
                return redirect('admin/index');
            }else{
                return back()->withErrors($validator);
            }
        }else{
            return view('admin.pass');
        }
    }
}
