<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class ConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd(222);
        //保存搜索条件
        $where = '';
        //实例化操作表
        $ob = DB::table('store_config');
        //判断是否有搜索条件
        // if($request->has('sex')){
        //     //获取搜索的条件
        //     $sex = $request->input('sex');
        //     //添加到将要携带到分页中的数组中
        //     $where['sex'] = $sex;
        //     //给查询添加where条件
        //     $ob->where('sex',$sex);
        // }
        if($request->has('keys')){
            //获取搜索的条件
            $keys = $request->input('keys');
            //添加到将要携带到分页中的数组中
            $where['config_keys'] = $keys;
            //给查询添加where条件
            $ob->where('config_keys','=',"{$keys}");
        }
        //执行分页查询
        $list = $ob->paginate(5);
        return view('Admin.config.index',['list'=>$list,'where'=>$where]);
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
        $data = DB::table('store_config')->where('config_id',$id)->first();
        return view('Admin.config.edit',['ob'=>$data]);
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
        $data = $request->only('config_title','config_keys','config_desn','config_state');
        $row = DB::table('store_config')->where('config_id',$id)->update($data);
        if($row>0){
            return redirect('admin/config')->with('msg','修改成功');
        }else{
            return redirect('admin/config')->with('error','修改失败');
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
        // $row = DB::table('store_config')->where('config_id',$id)->delete();
        // if($row>0){
        //     return redirect('admin/config')->with('msg','删除配置成功');
        // }else{
        //     return redirect('admin/config')->with('error','删除配置失败');
        // }
    }
}
