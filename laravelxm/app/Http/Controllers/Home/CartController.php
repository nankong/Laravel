<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 测试数据
        // session(['USER_CAT_INFO'=>array(
        //     array('temprory_gid'=>13,'temprory_num'=>1,'temprory_pic'=>'14926755712211.jpg','temprory_price'=>22)
        // )]);
        $list = session('USER_CAT_INFO');
        // dd($list);
        if(session('uid')){
            $uid = "/home/cart/confirmcart/1";
        }else{
            $uid = null;
        }
        if(empty($list)){
            return view('Home.Cart.none');
        }else{
            return view('Home.Cart.index')->with('uid',$uid);
        }
        // dd($list);
    }
    
    public function cartContent(Request $request)
    {
        //购物车中的数据ajax的形式返回
        //获取session的数据
        $cat_info=session('USER_CAT_INFO');
        // 进行有无数据判断
        if(!empty($cat_info)){
            //如果有数据就处理数据 得到想要的数据
            foreach($cat_info as $info){
                $goods_id=$info['temprory_gid'];
                // echo json_encode($goods_id);
                // $gooid = json_decode($goods_id);
                // 实际单价
                $goods_price=$info['temprory_price'];
                $goods_num=$info['temprory_num'];
                // //到商品表取其他的数据
                // // $goods_info=array();
                $goods_info=DB::table('store_goods')->where('goods_id',$goods_id)->first();
                if(empty($goods_info)){
                    //如果取不到数据就执行下一条数据
                    continue;
                } 
                $goods_original_price=$goods_info->goods_sale_price;
                $goods_tiny_pic=$goods_info->goods_big_pic;
                $goods_name=$goods_info->goods_name;
                $total_money=$goods_num*$goods_original_price;
                // 优惠金额
                $sale_money=$goods_num*($goods_original_price-$goods_price);
                $car_detial_info[]=array('goods_id'=>$goods_id,'goods_price'=>$goods_price,'goods_num'=>$goods_num,'goods_original_price'=>$goods_original_price,'goods_tiny_pic'=>$goods_tiny_pic,'goods_name'=>$goods_name,'total_money'=>$total_money,'sale_money'=>$sale_money);
            }
            // echo json_encode($car_detial_info);}
            // echo json_encode($goods_info);}
            // 总金额
            $car_total_money=0;
            // 优惠金额
            $car_sale_money=0;
            // 成交金额
            $car_end_money=0;
            $str="";
            foreach($car_detial_info as $ci){
                $car_total_money+=$ci['total_money'];
                $car_sale_money+=$ci['sale_money'];
                $car_end_money+=$ci['total_money']-$ci['sale_money'];
                $url='/home/Goodinfo/'.$goods_id;
                $str.="
                    <tr class='sc-pro-item'>
                        <td rowspan='1' class='tr-check'>
                            <input id='box-1989' class='checkbox' type='checkbox' name='newslist[]' value=".$ci['goods_id']." checked>
                        </td>
                        <td class='tr-pro'>
                            <div class='pro-area clearfix'>
                                <p class='p-img'>
                                    <a title=".$ci['goods_name']." target='_blank' href=".$url." seed='cart-item-name'>
                                        <img src='/Admin/upload/".$ci['goods_tiny_pic']."'".">
                                    </a>
                                </p>
                                <p class='p-name'>
                                    <a title=".$ci['goods_name']." target='_blank' href=".$url." seed='cart-item-name'>".$ci['goods_name']."</a>
                                </p>
                                <p class='p-sku'></p><p class='understock-1989 hide'></p>
                            </div>
                        </td>
                        <td class='tr-price'>
                            <span>".$ci['goods_price']."</span>
                        </td>
                        <td class='tr-quantity' rowspan='1'>                
                            <div class='sc-stock-area'>
                                <div class='stock-area'>
                                    <a title='减' class='icon-minus-3 vam'  id='cart_num_dec'  href='javascript:;'>
                                        <span>-</span>
                                    </a>
                                    <input type='text' autocomplete='off' value=".$ci['goods_num']." class='shop-quantity textbox vam' id='quantity-1989'  data-skuid='1989' data-type='1' seed='cart-item-num'>
                                    <a title='加' class='icon-plus-3 vam' id='cart_num_inc' href='javascript:void(0)' >
                                        <span>+</span>
                                        
                                    </a>
                                </div><p class='normalLimitstock-1989 hide'></p>
                            </div>
                        </td>
                        <td rowspan='1' class='tr-subtotal'>
                            <b>¥".$ci['total_money']."</b>
                        </td>
                        <td rowspan='1' class='tr-operate'>
                            <a href='javascript:void(0);' class='icon-sc-del' title='删除' seed='cart-item-del'>删除</a>
                        </td>
                    </tr>";
               }
               // 处理运费问题
               if($car_end_money < 200){
                    $car_end_money+=15;
                }
               $cat_status=1;
               $data["cat_status"]=$cat_status;
               $data["content"]=array('str'=>$str,'car_total_money'=>$car_total_money,'car_sale_money'=>$car_sale_money,'car_end_money'=>$car_end_money);
               echo json_encode($data);
           }else{
               $cat_status=0;
               $data["cat_status"]=$cat_status;
               echo json_encode($data);
        }
    }

    //更改购物车商品的数目
    public function changeGoodsNum(Request $request)
    {
        //标志  0失败 1成功
        $change_status=0;
        $goods_id=$request->input('goods_id');
        $num=$request->input('goods_num');
        $cat_info=session('USER_CAT_INFO');
        // echo json_encode($cat_info);
        if(!empty($cat_info)){
            $new_cat=array();
            foreach($cat_info as $info){
                if($info['temprory_gid']==$goods_id){
                        $info['temprory_num']=$num;
                        $new_cat[]=$info;
                }else{
                    $new_cat[]=$info;
                }
            }
            // session()->forget('USER_CAT_INFO');
            session()->put('USER_CAT_INFO',$new_cat);
            // $cat_info1=session('USER_CAT_INFO');
            // echo json_encode($cat_info1);
            $change_status=1;
        }else{
            $change_status=0;
        }
        echo $change_status;
    }
    
    //购物车 删除操作
    public function carDel(Request $request)
    {
        //删除的标志
        $del_status=0;
        $goods_id=$request->input('goods_id');
        $cat_info=session('USER_CAT_INFO');
        // echo json_encode($cat_info);
        if(!empty($cat_info)){
            $new_cat=array();
            foreach($cat_info as $info){
                if($info['temprory_gid']==$goods_id){

                }else{
                    $new_cat[]=$info;
                }

            }
            session()->put('USER_CAT_INFO',$new_cat);
            // $cat_info1=session('USER_CAT_INFO');
            // echo json_encode($cat_info1);
            $del_status=1;
          
        }else{
            $del_status=0;
        }
        echo $del_status;
    }
      
    // 购物车删除多个
    public function carDelNum(Request $request)
    {
        $goods_ids=$request->input('goods_ids');
        // 删除结果标志
        $delAll_status=0;
        if(!empty($goods_ids)){
            $goods_ids_arr=explode(",",trim($goods_ids,","));
            $cat_info=session('USER_CAT_INFO');
            if(!empty($cat_info)){
                $new_info=array();
                foreach($cat_info as $info){
                    if(in_array($info['temprory_gid'],$goods_ids_arr)){
                     
                    }else{
                        $new_info[]=$info;
                    }
                }
                session()->put('USER_CAT_INFO',$new_info);
                $delAll_status=1;
            }else{
                $delAll_status=0;
            }
        }else{
            $delAll_status=0;
        }
        echo  $delAll_status;
    }

}

