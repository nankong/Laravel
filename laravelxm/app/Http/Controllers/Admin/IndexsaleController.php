<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;

class IndexsaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        //保存搜索条件
        $where = '';
        //实例化操作表
        $ob = DB::table('store_index_sale');
        //判断是否有搜索条件
        if($request->has('index_sale_area')){
            //获取搜索的条件
            $index_sale_area = $request->input('index_sale_area');
            //添加到将要携带到分页中的数组中
            $where['index_sale_area'] = $index_sale_area;
            //给查询添加where条件
            $ob->where('index_sale_area','like',"%{$index_sale_area}%");
        }
        if($request->has('goods_id')){
            //获取搜索的条件
            $goods_id = $request->input('goods_id');
            //添加到将要携带到分页中的数组中
            $where['goods_id'] = $goods_id;
            //给查询添加where条件
            $ob->where('goods_id','like',"%{$goods_id}%");
        }
        //执行分页查询
        $list = $ob->paginate(5);
        return view('Admin.Indexsale.index',['list'=>$list,'where'=>$where]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('Admin.Indexsale.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);
        $message = [
            'index_sale_area.required' => '商品id必须填写',
            // 'index_sale_name.max:50' => '商品内容不得超过50',
            // 'index_sale_area.required' => '商品id必须填写',
        ];

        $this->validate($request, [
            'index_sale_area' => 'required|max:50',
            // 'index_sale_area' => 'required',
        ],$message);
        $data = $request->except('_token');
        //去商品表里查询是否有要添加到购物车的商品的id
        $g = DB::table('store_goods')->pluck('goods_id');
        $a='';
        foreach ($g as $k => $v) {
            //如果有给a附一个值
            if($data['index_sale_area'] == $g[$k]){
                $a = 2;
                break;
            }
        }
        //如果没有则返回没有的结果
        if(empty($a)){
            return redirect('admin/indexsale')->with('error','商品id不存在请重新添加');
        }
        // $uid = DB::table('store_admin')->where('Admin_name',session('Admin_name'))->value('Admin_id');
        $data['goods_id'] = 1;//$uid;
        $goods = DB::table('store_goods')->where('goods_id',$data['index_sale_area'])->get();
        if($goods[0]->goods_id){
            // dd($goods);
            $data['index_sale_pic'] = $goods[0]->goods_big_pic;
            // dd($data);
            $id = DB::table('store_index_sale')->insertGetId($data);
            if($id>0){
                return redirect('admin/indexsale')->with('msg','添加成功');
            }
        }
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
        $data = DB::table('store_index_sale')->where('index_sale_id',$id)->first();
        return view('Admin.Indexsale.edit',['ob'=>$data]);
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
        // dd($request);
        $data = $request->except('_token','_method');
        // dd($data);
        //$data = $request->only('index_sale_area');
        $row = DB::table('store_index_sale')->where('index_sale_id',$id)->update($data);
        if($row>0){
            return redirect('admin/indexsale')->with('msg','修改成功');
        }else{
            return redirect('admin/indexsale')->with('error','修改失败');
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
        $row = DB::table('store_index_sale')->where('index_sale_id',$id)->delete();
        if($row>0){
            return redirect('admin/indexsale')->with('msg','删除成功');
        }else{
            return redirect('admin/indexsale')->with('error','删除失败');
        }
    }

}
