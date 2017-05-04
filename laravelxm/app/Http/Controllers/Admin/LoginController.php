<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\store_admin;
use Gregwar\Captcha\CaptchaBuilder; // 验证码

class LoginController extends Controller
{
    //
    public function index()
    {
    	return view('Admin.login');
    }

    public function dologin(Request $request)
    {   
        //获取session中的验证码内容
        $mycode = session('mycode');
        // 判断用户输入的验证码和session中的内容是否一致
        if($mycode != $request->input('mycode')){
            return back()->with('msg','登录失败：验证码不正确');
        } 
    	// 实例化模型
    	$user = new store_admin();
    	// 调用模型中的验证用户的方法
    	$ob = $user->checkUser($request);

    	if($ob){
    		session(['adminuser' => $ob]);
    		return redirect("/admin/demo3");
    	}else{
    		return back()->with('msg','登入失败：用户名或者密码错误');
    	}
    }

    public function captch($tmp)
    {   
        // 生成验证码图片的builder对象，
        $builder = new CaptchaBuilder;
        // 设置验证码的宽高字体
        $builder->build(200,44,null);
        // 获取验证码中的内容
        $data = $builder->getPhrase();
        // 把验证码的内容闪存到session里面
        session()->flash('mycode',$data);
        // 告诉浏览器，这是一张图片
        // header('Cache-control')
        // header('Content-type:image/jpeg');
        // 生成图片
        // $builder->output();exit;
        // $builder = new CaptchaBuilder;
        // $builder->build(150,32,null);
        //Session::set('phrase',$builder->getPhrase()); //存储验证码
     
        return response($builder->output())->header('Content-type','image/jpeg');
    }

    public function over()
    {
        session()->forget('adminuser');
        return redirect('admin/login');
    }

}
