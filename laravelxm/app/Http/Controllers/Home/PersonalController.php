<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB,Redirect;

class PersonalController extends Controller
{
    public $uid;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // 
        $uid = $request->session()->get('uid');
        if($uid == null){
            $msg = '<div style="font-size:25px;margin:100px auto;width:500px;padding:20px;border:1px solid #eee;border-radius:0 20px 0 20px;box-shadow:0 6px 12px #eee;">您还未登陆！系统将在5秒之后自动跳转到登陆页...</div>';
            header("refresh:5;url='/home/login'");
            echo $msg;exit;
        } 
        //实例化操作表
        $ob = DB::table('store_user')->where('user_id', $uid)->first();
        return view('Home.PersonCenter.index',['list'=>$ob]);
    }

    public function pwd(Request $request)
    {
        $uid = $request->session()->get('uid');
        if($uid == null){
            $msg = '<div style="font-size:25px;margin:100px auto;width:500px;padding:20px;border:1px solid #eee;border-radius:0 20px 0 20px;box-shadow:0 6px 12px #eee;">您还未登陆！系统将在5秒之后自动跳转到登陆页...</div>';
            header("refresh:5;url='/home/login'");
            echo $msg;exit;
        }
        return view('Home.PersonCenter.pwd');
    }

    public function account(Request $request)
    {
        $uid = $request->session()->get('uid');
        if($uid == null){
            $msg = '<div style="font-size:25px;margin:100px auto;width:500px;padding:20px;border:1px solid #eee;border-radius:0 20px 0 20px;box-shadow:0 6px 12px #eee;">您还未登陆！系统将在5秒之后自动跳转到登陆页...</div>';
            header("refresh:5;url='/home/login'");
            echo $msg;exit;
        }
        // dd($uid);
        $m = DB::table('store_user')->where('user_id',$uid)->first();
        $ob = DB::table('store_order')->where([
            ['order_user_id', '=', $uid],
            ['order_state','>=', '1'],
        ])->get();
        // dd($ob);
        return view('Home.PersonCenter.account',['list'=>$ob,'m'=>$m]);
    }

    // 修改个人信息
    public function modper(Request $request){
        $uid = $request->session()->get('uid');
        if($uid == null){
            $msg = '<div style="font-size:25px;margin:100px auto;width:500px;padding:20px;border:1px solid #eee;border-radius:0 20px 0 20px;box-shadow:0 6px 12px #eee;">您还未登陆！系统将在5秒之后自动跳转到登陆页...</div>';
            header("refresh:5;url='/home/login'");
            echo $msg;exit;
        }
         //修改用户信息
        $modifier_status=0;
        $user_id=session('uid');
        // echo json_encode($request);
        $true_name=$request->input('true_name');
        $user_email=$request->input('user_email');
        $data['user_sex'] = $request->input('user_sex');
        // $secure_question=I('post.secure_question');
        // $secure_answer=I("post.secure_answer");    
        if(!empty($user_email)){
            $data['user_uemail']=$user_email;
         
        }
        // if(!empty($secure_answer)){
        //      $data['user_answer']=$secure_answer;
        //      $data['secure_id']=$secure_question;
        // }
        $data['user_truename']=$true_name;
        $user_info= DB::table('store_user')->where('user_id',$user_id)->update($data);
        // echo json_encode($request->input('user_sex'));
        if($user_info>0){
            $modifier_status=1;
         
        }else{
            $modifier_status=0;
        }
        echo $modifier_status;
    }

    public  function modpwd(Request $request){
        //修改密码的操作
        $uid = $request->session()->get('uid');
        if($uid == null){
            $msg = '<div style="font-size:25px;margin:100px auto;width:500px;padding:20px;border:1px solid #eee;border-radius:0 20px 0 20px;box-shadow:0 6px 12px #eee;">您还未登陆！系统将在5秒之后自动跳转到登陆页...</div>';
            header("refresh:5;url='/home/login'");
            echo $msg;exit;
        }
        $pwd_status=0;
        $o = md5($request->input('old_pwd'));
        $n = md5($request->input('new_pwd'));
        $up = DB::table('store_user')->where('user_id', $uid)->first();
        if($up->user_pass != $o){
            echo $pwd_status=2;exit;
        }
         // echo json_encode($up->user_pass);
         // echo $data['user_pass'];
         $data['user_pass']=$n;
        if(empty($uid)){
             $pwd_status=0;
        }else{
            $user_info=DB::table('store_user')->where('user_id',$uid)->update($data);
            if($user_info){
                session()->forget('uid');
                $pwd_status=1;
                //如果修改成功,就要让用户重新登录
            }else{
                $pwd_status=0;
            }
        }
        echo $pwd_status;
    }
}
