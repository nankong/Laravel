<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB,Session;

class OrderController extends Controller
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
        $ob = DB::table('store_order')->where('order_user_id', $uid);
        //执行分页查询
        $list = $ob->paginate(2);
        return view('Home.OrderCenter.index',['list'=>$list]);
    }

    //收货的控制方法
    public function  yesorder(Request $request)
    {
        //收货的id
        // echo $request->input('order_id');
        // echo 1;
        $order_status=0;         
        $order_id=$request->input('order_id');
        if(empty($order_id)){     
            $order_status=0;
        }else{
            $data['order_state'] = 5;
            $order_info=DB::table('store_order')->where('order_goodsid', $order_id)->update($data);
            if($order_info){
                $order_status=1;
            }else{
                $order_status=0;
            }  
        }
        echo $order_status;
    }
}
