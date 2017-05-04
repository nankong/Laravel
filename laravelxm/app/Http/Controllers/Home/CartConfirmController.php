<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;

class CartConfirmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        //
        $uid = session('uid');
        $uname = session('uname');
        if($uid && $uname){
            // 取默认地址
            $address = DB::table('store_address')->where(['address_default'=>1,'address_uid'=>$uid])->first();
            if(empty($address)){
                return redirect('/home/address')->with(['msg'=>'请先设置一个收货地址']);
            }
            $order_name=$address->address_consignee;
            // $order_name=$address->address_
            $order_tel=$address->address_consignee_phone;
            $order_detail=$address->address_province.$address->address_city.$address->address_county.$address->address_detail;
            // dd($address);
            // 取出购物车信息
            $cat_info=session('USER_CAT_INFO');
            // 进行有无数据判断
            if($id==1){
                if(!empty($cat_info)){
                    foreach($cat_info as $info){
                        $goods_id=$info['temprory_gid'];
                        $goods_price=$info['temprory_price'];
                        $goods_pic=$info['temprory_pic'];
                        $goods_num=$info['temprory_num'];
                        $goods_info=DB::table('store_goods')->where('goods_id',$goods_id)->first();
                        $goods_name=$goods_info->goods_name;
                        // 商品小计
                        $total_money=$goods_num*$goods_price;
                        $sale_money=$goods_price-$goods_price;
                        $car_detial_info[]=array('order_goodsid'=>$goods_id,'order_goodspic'=>$goods_pic,'order_price'=>$goods_price,'order_goodsnum'=>$goods_num,'sale_money'=>$sale_money,'order_goodsnam'=>$goods_name,'order_pricesum'=>$total_money,'address_consignee'=>$address->address_consignee);
                    }
                    $car_detial = $car_detial_info;
                    // dd($car_detial);
                    // dd($order_detail);
                    // 总金额
                    $car_total_money=0;
                    // 优惠金额
                    $car_sale_money=0;
                    // 成交金额
                    $car_end_money=0;
                    $order_od_numb = time();
                    foreach($car_detial_info as $ci){
                        $car_total_money+=$ci['order_pricesum'];
                        $car_sale_money+=$ci['sale_money'];
                        $car_end_money+=$ci['order_pricesum']-$ci['sale_money'];
                        $data[]=array('order_goodsid'=>$ci['order_goodsid'],'order_goodspic'=>$ci['order_goodspic'],'order_price'=>$ci['order_price'],'order_goodsnum'=>$ci['order_goodsnum'],'order_goodsnam'=>$ci['order_goodsnam'],'order_pricesum'=>$ci['order_pricesum'],'order_state'=>0,'order_user_id'=>$uid,'order_od_numb'=>$order_od_numb,'order_name'=>$order_name,'order_tel'=>$order_tel,'order_detail'=>$order_detail,'order_time'=>$order_od_numb,'order_total'=>$car_total_money);
                    }
                    // dd($data);
                    if($car_end_money<=200){
                        $yunfei = 15;
                        $car_end_money+=15;
                    }else{
                        $yunfei = 0;
                    }
                    // dd($car_detial);
                    // 保存订单信息到订单表
                    // $data = '';
                    foreach ($data as $v) {
                        $oid[] = DB::table('store_order')->insertGetId($v);
                    }
                    // dd($data);
                    if($oid){
                        session()->forget('USER_CAT_INFO');
                        return redirect("/home/cart/confirmcart/{$order_od_numb}");
                        // return view('Home.Cart.confirmcart',['add'=>$address,'list'=>$car_detial,'car_total_money'=>$car_total_money,'car_sale_money'=>$car_sale_money,'car_end_money'=>$car_end_money,'yunfei'=>$yunfei]);


                    }else{
                        alert('订单创建失败，请重试！');
                    }
                }else{
                    alert('订单创建失败，请重试！');
                }
            }else{
                // 从订单表中根据订单编号查询订单信息
                $list = DB::table('store_order')->where('order_od_numb',$id)->get();
                $list2 = DB::table('store_order')->where('order_od_numb',$id)->first();
                if($list2->order_state==0){
                    $address = DB::table('store_address')->where(['address_default'=>1,'address_uid'=>$uid])->first();
                    // dd($list);
                    $car_total_money=0;
                    $car_sale_money=0;
                    $car_end_money=0;
                    foreach ($list as $v) {
                        // 商品小计
                        $car_total_money+=$v->order_pricesum;
                        // 商品优惠
                        $car_sale_money+=0;
                        // 商品总计
                        $car_end_money+=$v->order_pricesum-0;
                        $order_detail=$v->order_detail;
                    }
                    if($car_end_money<=200){
                        $yunfei = 15;
                        $car_end_money+=15;
                    }else{
                        $yunfei = 0;
                    }
                    return view('Home.Cart.confirmcart',['add'=>$address,'order_detail'=>$order_detail,'list'=>$list,'car_total_money'=>$car_total_money,'car_sale_money'=>$car_sale_money,'car_end_money'=>$car_end_money,'yunfei'=>$yunfei,'id'=>$id]);
                }else{
                    return redirect('/home/order');
                }
            }    
        }else{
            return redirect('/home/login');
        }
    }

}
