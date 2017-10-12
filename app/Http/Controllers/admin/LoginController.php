<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Gregwar\Captcha\CaptchaBuilder;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.login');
    }

    public function dologin(Request $request)
    {
        $name = $request->input('name');
        //获取session中的验证码
        $mycode = session('mycode');
        // 判断用户输入的验证码和session中的验证码是否一致
        if($mycode != $request->input('mycode')){
            return back()->with('msg', '登录失败：验证码错误！');
        }
        
        $ob = \DB::table('stu')->where('name', $name)->first();

        // dd($ob);
        if($ob){
            if($ob->pass == $request->input('pass')){
                session(['adminuser' => $ob]);
                return redirect('admin/index');
            }
        }else{
            //回到上一页
            return back()->with('msg', '登录失败：用户名或密码错误');
        }
    }

    public function captcha($tmp)
    {
        //生成验证码图片的Builder对象，配置相应属性 
        $builder = new CaptchaBuilder; 
        //可以设置图片宽高及字体 
        $builder->build($width = 200, $height = 40, $font = null); 
        //获取验证码的内容 
        $phrase = $builder->getPhrase(); 
        //把内容存入session 
        session()->flash('mycode', $phrase);
        //生成图片 
        return response($builder->output())->header('Content-type','image/jpeg');
    }
}

