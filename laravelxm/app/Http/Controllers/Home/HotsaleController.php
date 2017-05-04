<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;

class HotsaleController extends Controller
{
    
    public function index()
    {
        // 去热销商品表遍历处理ajax返回结果
        $hotStr = '';
        $hotInfo= DB::table('store_goods')->where('goods_state','hot')->take(3)->get();
        // echo json_encode($hotInfo);
        if($hotInfo){
            $data['status']=1;
            // 循环遍历输出
            $i=1;
            // echo json_encode($i);
            foreach($hotInfo as $info){
                $id=$info->goods_id;
                //路径信息
                $url = "/home/goodinfo/$id";
                // echo json_encode($url);
              $str=<<<EOF
             
                <li>
                <div>
                    <p  class="p-img"><a  href="$url"  title="{{ $info->goods_name }}"><img  src=" /admin/upload/$info->goods_big_pic "  alt=" asset('admin/upload')/ $info->goods_big_pic "></a>
                    <!--------S记录着第几个商品-------->
                    
                    <p  class="p-name"><a  href="$url"  title="{{ $info->goods_name }}"> $info->goods_name </a></p>
                    <p  class="p-price"><b>¥ $info->goods_sale_price </b></p>
                </div>
            </li>
               
               
               
EOF;
            // echo json_encode($str);   
            $hotStr .=$str; 
            $i++;
            }//foreach         
            $data['content']=$hotStr;
            echo json_encode($data);
        }
    }   
}
