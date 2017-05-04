<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Home.login');
    }

    public function dologin(Request $request)
    {   
        $list = DB::table('store_user')->where([
            ['user_username',$request->input('uname')],
            ['user_pass',md5($request->input('pwd'))]
        ])->first();
        // echo json_encode($user_id);
        if($list){
            // 保存用户信息到session
            $userid = $list->user_id;
            $username = $list->user_username;
            session(['uid' => $userid,'uname' => $username]);
            $status=2;
        }else{
            // 用户名密码不正确
            $status=0;
        }
        echo $status;
    }

    public function yzmcode(Request $request)
    {
        //获取session中的验证码内容
        $mycode = session('mycode');
        // 判断用户输入的验证码和session中的内容是否一致
        if($mycode == $request->input('code')){
            echo 1;
        }else{
            echo 0;
        }
        
    }

    public function checklogin(Request $request)
    {
    //看session是否保存有用户信息
    $login_status = 0;  //登录后的标志  0 未登录 1 登录
    $user_id = session('uid');
    $user_uname = session('uname');
    // $user_info=session(C("USER_INFO"));
    //存在表示用户已经登录
    if($user_id&&$user_uname){
        $login_status=1;
        $user_name = session('uname');
        }else{
         $login_status=0;
        }
        $data['login_status']=$login_status;
        $data['user_name']=$user_name;
        // $data['user_level']=$user_level;
        echo json_encode($data);
    }

    public function quit(Request $request)
    {
        session()->forget('uid');
        return redirect('home/login');
    }
}