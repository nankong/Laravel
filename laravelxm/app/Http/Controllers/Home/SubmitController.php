<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;

class SubmitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $uid = session('uid');
        $uname = session('uname');
        if($uid && $uname){
            $user = DB::table('store_user')->where('user_id',$uid)->first();
            if($user->user_money==null){
                $user->user_money=0;
            }
            $order = DB::table('store_order')->where('order_user_id',$uid)->first();
            if($order->order_total<200){
                $order->order_total+=15;
            }
            $leftmoney = $user->user_money-$order->order_total;
            $data['user_money']=$leftmoney;
            $uid = DB::table('store_user')->where('user_id',$uid)->update($data);
            // dd($leftmoney);
            // dd($user->user_money);
            return view('Home.Cart.submitcart',['id'=>$id,'user_money'=>$user->user_money,'end_money'=>$order->order_total,'leftmoney'=>$leftmoney]);
        }else{
            return redirect('/home/login');
        }
    }

    public function dosubmit($num)
    {
        // dd($id);
        $uid = session('uid');
        $uname = session('uname');
        if($uid && $uname){
            $id = DB::table('store_order')->where('order_user_id',$uid)->update(['order_paytime'=>time(),'order_state'=>2]);
            if($id>0){
                return view('Home.Cart.payment')->with(['msg'=>'付款成功，我们将尽快为你发货,也请你注意查收快递信息！','id'=>$num]);
            }else{
                return view('Home.Cart.payment')->with(['msg','付款失败，请稍后再试！','id'=>$num]);
            }
        }else{
            return redirect('/home/login');
        }
    }

}

