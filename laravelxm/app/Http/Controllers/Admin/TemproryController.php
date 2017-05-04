<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;

class TemproryController extends Controller
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
        $ob = DB::table('store_temprory');
        //判断是否有搜索条件
        if($request->has('temprory_gid')){
            //获取搜索的条件
            $temprory_gid = $request->input('temprory_gid');
            //添加到将要携带到分页中的数组中
            $where['temprory_gid'] = $temprory_gid;
            //给查询添加where条件
            $ob->where('temprory_gid','like',"%{$temprory_gid}%");
        }
        if($request->has('temprory_uid')){
            //获取搜索的条件
            $temprory_uid = $request->input('temprory_uid');
            //添加到将要携带到分页中的数组中
            $where['temprory_uid'] = $temprory_uid;
            //给查询添加where条件
            $ob->where('temprory_uid','like',"%{$temprory_uid}%");
        }
        //执行分页查询
        $list = $ob->paginate(1);
        return view('Admin.Temprory.index',['list'=>$list,'where'=>$where]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('Admin.Temprory.add');
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
            'temprory_gid.required' => '商品id必须填写',
            // 'temprory_name.max:50' => '商品内容不得超过50',
            // 'temprory_gid.required' => '商品id必须填写',
        ];

        $this->validate($request, [
            'temprory_gid' => 'required|max:50',
            // 'temprory_gid' => 'required',
        ],$message);
        $data = $request->except('_token');
        //去商品表里查询是否有要添加到购物车的商品的id
        $g = DB::table('store_goods')->pluck('goods_id');
        $a='';
        foreach ($g as $k => $v) {
            //如果有给a附一个值
            if($data['temprory_gid'] == $g[$k]){
                $a = 2;
                break;
            }
        }
        //如果没有则返回没有的结果
        if(empty($a)){
            return redirect('admin/temprory')->with('error','商品id不存在请重新添加');
        }
        // $uid = DB::table('store_admin')->where('Admin_name',session('Admin_name'))->value('Admin_id');
        $data['temprory_uid'] = 1;//$uid;
        $goods = DB::table('store_goods')->where('goods_id',$data['temprory_gid'])->get();
        if($goods[0]->goods_id){
            // dd($goods);
            $data['temprory_pic'] = $goods[0]->goods_big_pic;
            // dd($data);
            $id = DB::table('store_temprory')->insertGetId($data);
            if($id>0){
                return redirect('admin/temprory')->with('msg','添加成功');
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
        $data = DB::table('store_temprory')->where('temprory_id',$id)->first();
        return view('Admin.Temprory.edit',['ob'=>$data]);
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
        $data = $request->only('temprory_name');
        // dd($data);
        //$data = $request->only('temprory_gid');
        $row = DB::table('store_temprory')->where('temprory_id',$id)->update($data);
        if($row>0){
            return redirect('admin/temprory')->with('msg','修改成功');
        }else{
            return redirect('admin/temprory')->with('error','修改失败');
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
        $row = DB::table('store_temprory')->where('temprory_id',$id)->delete();
        if($row>0){
            return redirect('admin/temprory')->with('msg','删除成功');
        }else{
            return redirect('admin/temprory')->with('error','删除失败');
        }
    }

}
