<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB,Redirect;

class SmallCatController extends Controller
{
    public function myshop(Request $request){
        // 这是我的商城的控制器
        // 看session是否保存有用户信息
        $login_status=0;  //登录后的标志  0 未登录 1 登录
        $user_id=session('uid');
        $user_info=session('uname');
        // echo json_encode($user_id);
        // 存在表示用户已经登录
        if($user_id&&$user_info){
            $login_status=1;
            // 计算需要评论和付款的订单
            $unpay_count=DB::table('store_order')->where(['order_user_id'=>$user_id,'order_state'=>0])->count();
            $uncomment_count=DB::table('store_order')->where(['order_user_id'=>$user_id,'order_state'=>5])->count();
        }else{
             $login_status=0;
        }
        $data['login_status']=$login_status;
        $data['user_name']=$user_info;
        $data['unpay_count']=$unpay_count;
        $data['uncomment_count']=$uncomment_count;
        echo json_encode($data);
    }
        
   public function mygoods(Request $request){
        // 查询购物车中的商品 
        $cat_status=0;  // 标志0失败 1成功
        $session_info=session('USER_CAT_INFO');
        // 判断购物车是否有商品
        if($session_info){
            // 如果存在就进行遍历想要的数据 对数据遍历想要的形式
            // $new_sort_goods=array();
            foreach($session_info as $info){
                $temprory_id=$info['temprory_gid'];
                // 到数据查询要的信息 名字
                $temprory_info=DB::table('store_goods')->where('goods_id',$temprory_id)->first();
                if(!$temprory_info){
                    continue;
                }
                $data['goods_id']=$temprory_id;
                $data['goods_name']=$temprory_info->goods_name;
                $data['goods_tiny_pic']=$temprory_info->goods_big_pic;
                $data['goods_num']=$info['temprory_num'];
                $data['goods_price']=$info['temprory_price'];
                $new_sort_goods[]=$data;
            }
            // foreach($new_sort_goods as $new_goods){
            //     echo json_encode($new_goods['goods_num']);
            // }
            
        
            //往前台显示
            if(count($new_sort_goods)){
                $str = '';
                $cat_total_num=0; $cat_total_price=0;
                foreach($new_sort_goods as $new_goods){                    
                $url='/home/goodinfo/'.$new_goods['goods_id'];
                $tiny_pic="/admin/upload".$new_goods['goods_tiny_pic'];
                $str .="<li class='minicart-pro-item'><div class='pro-info'><div class='p-img'><a href=".$url." title=".$new_goods['goods_name']." target='_blank'><img src='/Admin/upload/".$new_goods['goods_tiny_pic']."'"."></a></div><div class='p-name'><a href=".$url." title=".$new_goods['goods_name']." target='_blank'>".$new_goods['goods_name']."&nbsp;<span class='p-slogan'></span><span class='p-promotions hide'></span></a></div><div class='p-price'><b>￥&nbsp;".$new_goods['goods_price']."</b><em>x</em><span>".$new_goods['goods_num']."</span></div><a href='javascript:;' class='icon-minicart-del' title='删除'' >删除</a><input type='hidden' name='goods_id' value=".$new_goods['goods_id']."></div>
                        </li>";
                $cat_total_num+=$new_goods['goods_num'];
                $cat_total_price+=$new_goods['goods_num']*$new_goods['goods_price'];
                }
                $cat_status=1;
            }else{
                $cat_status=0;
            }    
        }else{
            $cat_status=0;
        }
        $cat_data['cat_status']=$cat_status;
        $cat_data['content']=array('total_nums'=>$cat_total_num,'total_price'=>$cat_total_price);
        $cat_data['info']=$str;
        echo json_encode($cat_data);
    }

     
    public function delgoods(Request $request){
         // 删除商品 ajax实现
        $del_status=0; // 删除成功是否的标志 0失败 1成功
        $temprory_id=$request->input('goods_id');
        $session_info=session('USER_CAT_INFO');
        if(empty($temprory_id)){
        $del_status=0;
        }else{
            $new_session=array();  // 执行删除后存的数组
        foreach($session_info as $info){
            if($info['temprory_gid']!=$temprory_id){
                $new_session[]=$info;
                } 
            }
            // 计算新的数目和总金额
            $total_num=0;$total_money=0;
            foreach($new_session as $info){
                $total_num+=$info['temprory_num'];
                $total_money+=$info['temprory_num']*$info['temprory_price'];
            }
        session()->put('USER_CAT_INFO',$new_session);
        $del_status=1;
        }
        $data['del_status']=$del_status;
        $data['total_num']=$total_num;
        $data['total_money']=$total_money;
        echo json_encode($data);
    }

     public function doadd(Request $request)
    {   
        
        // 获取商品的ID 和购买的数量
        $goods_id = $request->input('goods_id');
        $num = $request->input('num');
        $status=0;
        if(empty($num)||empty($goods_id)){
            $status=0;
        }else{
            // 先查找有无此商品
            $goods_info = DB::table('store_goods')->where('goods_id',$goods_id)->get();
            // echo json_encode($goods_info[0]->goods_sale_price);
            $goods_price = $goods_info[0]->goods_sale_price;
            $goods_pic = $goods_info[0]->goods_big_pic;
            // 把值给数组
            $data['temprory_gid']=$goods_id;
            $data['temprory_price']=$goods_price;
            $data['temprory_num']=$num;
            $data['temprory_pic']=$goods_pic;
            // 查询原来是否有商品
            // 读取session的data
            $session_data = session('USER_CAT_INFO');
            // 遍历session 看商品是否在session中
            if(!empty($session_data)){   
                foreach($session_data as $info){
                    if($info['temprory_gid']==$goods_id){
                        // 说明在session中  只加数目 
                        $data['temprory_num']=$data['temprory_num']+$info['temprory_num'];                   
                    }else{
                        // 如果没有找到就保存到新的
                        $new_session[]=$info;                       
                    }
                }                
            } 
            $new_session[]=$data; 
            // 重新保存session
            session(['USER_CAT_INFO'=>$new_session]);
            $status=1; 
            // 发送到前台
            $send['status']=$status;
            $send['content']=$data['temprory_num'];
            echo json_encode($send);
            // echo json_encode(session('USER_CAT_INFO'));           
        }
    }

    public function buy(Request $request)
    { 
        //  获取商品ID 和数量
        $goods_id = $request->input('goods_id');
        $num = $request->input('num');
        $status=1;
        // echo json_encode($status);
        // 移除原购物车中的商品
        session()->forget('USER_CAT_INFO');

        // 存入立即购买的数据
        $list =DB::table('store_goods')->where('goods_id',$goods_id)->get();

        // 取出价格
        $goods_sale_price = $list[0]->goods_sale_price;
        // 取出图片
        $goods_pic = $list[0]->goods_big_pic;
        // echo json_encode($goods_pic);
        // 存到data 中
        $data['temprory_gid'] = $goods_id;
        $data['temprory_price'] = $goods_sale_price;
        $data['temprory_num'] = $num;
        $data['temprory_pic'] = $goods_pic;
        // echo json_encode($data);
        $new_session[] = $data;
        // 存到session 中
        session(['USER_CAT_INFO' => $new_session]);
        // return redirect('Home.Cart.index');
        // echo json_encode($new_session);
        $status = 1;
        echo json_encode($status);
    }
    
    public function gobuy()
    {
        // return view('Home.Cart.index');
        return redirect('/home/cart/index');
    }

}
