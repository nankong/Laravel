<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;

class AddressController extends Controller
{
    public $uid;

    // public function __construct()
    // {
    //     $this->uid = session('uid');
    //     // dd($this->uid);
    //     $this->isLogin();
    // }

    // public function isLogin()
    // {
    //     if($this->uid == null){
    //         $msg = '<div style="font-size:25px;margin:100px auto;width:500px;padding:20px;border:1px solid #eee;border-radius:0 20px 0 20px;box-shadow:0 6px 12px #eee;">您还未登陆！系统将在5秒之后自动跳转到登陆页...</div>';
    //         header("refresh:5;url='/home/login'");
    //         echo $msg;exit;
    //     }
    // }

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
        //实例化操作表
        $ob = DB::table('store_address')->where('address_uid', $uid);
        //执行分页查询
        $list = $ob->paginate(2);
        // dd($list);
        // dd($order_goods['0']->order_goodsnam);
        return view('Home.PersonCenter.address',['list'=>$list]);
    }
    //添加地址
    public function addAddress(Request $request)
    {
        $uid = $request->session()->get('uid');
        if($uid == null){
            $msg = '<div style="font-size:25px;margin:100px auto;width:500px;padding:20px;border:1px solid #eee;border-radius:0 20px 0 20px;box-shadow:0 6px 12px #eee;">您还未登陆！系统将在5秒之后自动跳转到登陆页...</div>';
            header("refresh:5;url='/home/login'");
            echo $msg;exit;
        }
        $data = $request->except('_token','randomFlag');
        $data['address_uid'] = $uid;
        // dd($request->address_default);
        // dd($data);
        if($request->address_default){
            // dd(1111);
            $a = DB::table('store_address')->update(['address_default' => 0]);
            $data['address_default'] = 1;
        }
        // dd($data);
        $id = DB::table('store_address')->insertGetId($data);
        if($id>0){
            return redirect('home/address')->with('msg','添加成功');
        }
    }
    //删除地址
    public function deladd(Request $request)
    {
        // echo 1;
        // echo json_encode($request->input('aid'));
        $id = $request->input('aid');
        $row = DB::table('store_address')->where('address_id',$id)->delete();
        if($row>0){
            echo 1;
        }else{
            echo 0;
        }
    }
    //修改默认地址
    public function defadd(Request $request)
    {
        // echo 1;
        $id = $request->input('aid');
        //  $data['address_default'] = 0;
        $a = DB::table('store_address')->update(['address_default' => 0]);
        // update store_address set address_defalut = 0 
        // echo json_encode($a);
        $data['address_default'] = 1;
        $b = DB::table('store_address')->where('address_id',$id)->update($data);
        // echo $v->address_default;
        // echo json_encode($r)
       if($b>0){
            echo 1;
        }else{
            echo 0;
        }
    }
    
}
