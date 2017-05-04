<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;

class CollectController extends Controller
{
    // 查询收藏表
    public function add(Request $request)
    {   
        // 获取商品的ID
        $id = $request->input('goods_id');
        $data = session('uid');
        // 判断用户是否登入 
        if($data){
            // 判断用户是否已删除
            $col = DB::table('store_collect')->where(['collect_uid'=>session('uid'),'collect_gid'=>$id])->first();
            if($col){
                // 如果是2 则已收藏
                $status = 2;
            }else{
                $newdata['collect_gid'] = $id;
                $newdata['collect_uid'] = $data;
                $newdata['collect_time'] = time();
                // echo json_encode($newdata);
                // 添加
                $id = DB::table('store_collect')->insert( array('collect_gid' =>$id,'collect_uid'=>session('uid'),'collect_time'=>time()));
                // 返回结果
                // if($id>0){
                    $status = 1;
                // }
            }
            
        }else{
            // $list = DB::table('store_collect')->where('collect_id',session('uid'))->get();
            // return view('Home.collect.index',['list'=>$list]);
            $status = 0;
            
        }
        echo json_decode($status);

        
    }

    public function index()
    {   
        // echo json_encode(session('uid'));
        if(session('uid')){
            //查询收藏表 
            // $list = DB::table('store_collect')->where('collect_uid',session('uid'))->get();

            // return redirect('Home.collect.index',['list'=>$list]);
            $status = 1;
            echo json_encode($status);
        }else{
            $status = 0;
            echo json_encode($status);
        }
    }

    public function look()
    {   
        // 查询用户收藏的商品
        $list = DB::table('store_goods')->join('store_collect','goods_id','collect_gid')->where('collect_uid',session('uid'))->get();
        // dd($list);

        return view('Home.collection.index',['list'=>$list]);

    }

    public function del(Request $request,$id)
    {
        //删除收藏表中数据
        $delete = DB::table('store_collect')->where(['collect_gid'=>$id,'collect_uid'=>session('uid')])->delete();
        if($delete > 0 ){
            return redirect('/home/collect/look')->with('msg','删除成功!');
        }else{
            return redirect('/home/collect/look')->with('error','删除失败!');
        }
    }


}
