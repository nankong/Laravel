<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;

class GoodinfoController extends Controller
{
    
    public function index(Request $quest,$id)
    {   
        // dd($id);
        // 查询商品的信息
        $row = DB::table('store_goods')->where('goods_id','=',$id)->first();
        // 查询该商品的评论和评论的用户
        $user = DB::table('store_user')->join('store_comment','user_id','comment_uid')->where('comment_gid',$id)->get();
        // 查询最新的二条上架信息
        $new = DB::table('store_goods')->orderby('goods_id','desc')->take(2)->get();
        return view('Home.product.index',['ob'=>$row,'user'=>$user,'new'=>$new]);
    }
    
}
