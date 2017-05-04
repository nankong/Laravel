<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //保存搜索条件
        $where = '';
        //实例化操作表
        $ob = DB::table('store_order');
        //判断是否有搜索条件
        if($request->has('id')){
            //获取搜索的条件
            $id = $request->input('id');
            //添加到将要携带到分页中的数组中
            $where['order_od_numb'] = $id;
            //给查询添加where条件
            $ob->where('order_od_numb','=',"{$id}");
        }
        //执行分页查询
        $list = $ob->paginate(5);
        return view('Admin.Order.index',['list'=>$list,'where'=>$where]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data = DB::table('store_order')->where('order_id',$id)->first();
        return view('Admin.Order.edit',['ob'=>$data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $data = $request->only('order_state','order_detail','order_name');
        $row = DB::table('store_order')->where('order_od_numb',$id)->update($data);
        if($row>0){
            return redirect('admin/order')->with('msg','修改成功');
        }else{
            return redirect('admin/order')->with('error','修改失败');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $row = DB::table('store_order')->where('order_od_numb',$id)->delete();
        if($row>0){
            return redirect('admin/order')->with('msg','删除订单成功');
        }else{
            return redirect('admin/order')->with('error','删除订单失败');
        }
    }
}
