<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB,Redirect;

class IndexController extends Controller
{
     public function index(){

        //广告类商品
        //广告a区
        // $Ad = M('ad');
        // $Adlist = $Ad->where("index_sale_area='a'")->select();
        // $this->a=$Adlist;

        // //广告b区
        // $Ad = M('ad');
        // $Adlist = $Ad->where("index_sale_area='b'")->select();
        // $this->b=$Adlist;

        // //广告c区
        // $Ad = M('ad');
        // $Adlist = $Ad->where("index_sale_area='c'")->select();
        // $this->c=$Adlist;  

        // 公告管理
        $notice = DB::table('store_notice')->get();
        //热门类商品
        $hot_sale = DB::table('store_index_sale')->join('store_goods','store_index_sale.goods_id','store_goods.goods_id')->where('index_sale_area','hot')->orderby('store_goods.goods_id','desc')->take(4)->get();
        //手机类商品 
        $phone_sale = DB::table('store_index_sale')->join('store_goods','store_index_sale.goods_id','store_goods.goods_id')->where('index_sale_area','phone')->orderby('store_goods.goods_id','desc')->take(7)->get();
        //电脑类商品
        $ipad_sale = DB::table('store_index_sale')->join('store_goods','store_index_sale.goods_id','store_goods.goods_id')->where('index_sale_area','ipad')->orderby('store_goods.goods_id','desc')->take(3)->get();
        //友情链接
        $link = DB::table('store_links')->where('links_switch',1)->get();
        return view('Home.index',['hot_sale'=>$hot_sale , 'phone_sale'=>$phone_sale, 'ipad_sale'=>$ipad_sale, 'link'=>$link, 'notice'=>$notice]);
        // dd($sale);
    }

    public function config(Request $request)
    {
        $conf = DB::table('store_config')->pluck('config_state');
        echo json_encode($conf);
    }
}
