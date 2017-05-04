<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;

class ListController extends Controller
{
    
    public function index(Request $request,$id)
    {   
        // 查询分类表
        $cate = DB::table('store_category')->where('category_id',$id)->first();
        // 查询数据该分类商品
        $ob=DB::table('store_goods');
        // 查询条件
        $ob->where('category_id',$id);
        // 每页3条
        $list = $ob->paginate(3);
        $where['category_id'] = $id;
        return view('Home.List.index',['list'=>$list,'cate'=>$cate,'where'=>$where]);
    }
}
