<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB,Redirect;

class SearchController extends Controller
{
    public function index(Request $request, $keywords){
        //获取keyword进行判断
        // dd($request->input('ob'));
        // dd($keywords);
        //对关键字判断如果为空
        $keywords = trim($keywords);
        if(empty($keywords)){
            // dd(111);
            return view('Home.Search.error',['keywords'=>$keywords]);
            exit;
        }

        //对数据进行分页处理
        // 实例化操作表
        $ob = DB::table('store_goods');  
        //去商品表匹配商品
        $search='%'.$keywords.'%';
        $search_info=$ob->where('goods_name','like',$search)->get();
        // var_dump($search_info);die;
        //如果没有此商品
        if($search_info->isEmpty()){
            // dd(111);
            return view('Home.Search.error',['keywords'=>$keywords]);
            exit;
        }
          
        //找到了商品对商品进行处理
        // //接受order 进行排序处理 
        // $order = '';
        $order = $request->input('ob');
        $where['ob'] = $order;
        // dd($where);
        if($order=='time'){
            $order="goods_time"; //按上市时间进行排序处理
        }else if($order=='price'){
            $order="goods_sale_price";//按价格进行处理
        }else{
            $order="goods_id";//按id排序
        }
        //执行分页查询
        $search_info = $ob->where('goods_name','like',$search)->orderby($order,'asc')->paginate(10);
        // 查询满足要求的总记录数
        $goods_count=DB::table('store_goods')->where('goods_name','like',$search)->count(); 
        // dd($search_info);
        return view('Home.Search.index',['where'=>$where,'search_info'=>$search_info,'keywords'=>$keywords,'goods_count'=>$goods_count]);
    }
}
