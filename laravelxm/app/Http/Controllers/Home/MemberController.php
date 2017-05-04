<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $uid = $request->session()->get('uid');
        if($uid == null){
            $msg = '<div style="font-size:25px;margin:100px auto;width:500px;padding:20px;border:1px solid #eee;border-radius:0 20px 0 20px;box-shadow:0 6px 12px #eee;">您还未登陆！系统将在5秒之后自动跳转到登陆页...</div>';
            header("refresh:5;url='/home/login'");
            echo $msg;exit;
        }
        //$uid = 13;
        //保存搜索条件
        $where = '';
        //实例化操作表
        $ob = DB::table('store_user')->where('user_id', $uid)->first();
        return view('Home.Member.index',['list'=>$ob,'where'=>$where]);
    }
    
}
