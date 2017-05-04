<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB,Session;

class CommentController extends Controller
{
    public $uid;

    public function isLogin()
    {
        
       
    }
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
        //保存搜索条件
        $where = '';
        //实例化操作表
        $ob = DB::table('store_comment')->join('store_goods','comment_gid','goods_id')->where('comment_uid',$uid);
        //判断是否有搜索条件
        if($request->has('order_gid')){
            //获取搜索的条件
            $order_gid = $request->input('order_gid');
            //添加到将要携带到分页中的数组中
            $where['order_gid'] = $order_gid;
            //给查询添加where条件
            $ob->where('order_gid','like',"%{$order_gid}%");
        }
        if($request->has('order_uid')){
            //获取搜索的条件
            $order_uid = $request->input('order_uid');
            //添加到将要携带到分页中的数组中
            $where['order_uid'] = $order_uid;
            //给查询添加where条件
            $ob->where('order_uid','like',"%{$order_uid}%");
        }
        //执行分页查询
        $list = $ob->paginate(5);
        // dd($list);
        // dd($order_goods['0']->order_goodsnam);
        return view('Home.Comment.index',['list'=>$list,'where'=>$where]);
    }

  public function addcomment(Request $request)
  {
    // dd(111);
    $uid = $request->session()->get('uid'); 
    $time = time();
    if($uid == null){
        $msg = '<div style="font-size:25px;margin:100px auto;width:500px;padding:20px;border:1px solid #eee;border-radius:0 20px 0 20px;box-shadow:0 6px 12px #eee;">您还未登陆！系统将在5秒之后自动跳转到登陆页...</div>';
        header("refresh:5;url='/home/login'");
        echo $msg;exit;
    }
    $con = $request->except('_token','randomFlag');
    $con['comment_uid'] = $uid;
    $con['comment_pubtime'] = $time; 
    // dd($con);
    $id = DB::table('store_comment')->insertGetId($con);
    if($id>0){
        $data['order_state'] = 6;
        DB::table('store_order')->where('order_goodsid',$con['comment_gid'])->update($data);
        return redirect('home/order')->with('msg','评论成功');
    }
   
  }

}
