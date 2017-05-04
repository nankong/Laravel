<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class AddressController extends Controller
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
        $ob = DB::table('store_address');
        //判断是否有搜索条件
        if($request->has('id')){
            //获取搜索的条件
            $id = $request->input('id');
            //添加到将要携带到分页中的数组中
            $where['address_consignee_phone'] = $id;
            //给查询添加where条件
            $ob->where('address_consignee_phone','=',"{$id}");
        }
        //执行分页查询
        $list = $ob->paginate(5);
        return view('Admin.address.index',['list'=>$list,'where'=>$where]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('Admin.Address.add');
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
        // $this->validate($request, [
        //     'name' => 'required|max:8',
        //     'age' => 'integer|max:150|min:18',
        // ],$this->messages());
        $data = $request->except('_token');
        $id = DB::table('store_address')->insertGetId($data);
        if($id>0){
            return redirect('admin/address')->with('msg','添加成功');
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
        $data = DB::table('store_address')->where('address_id',$id)->first();
        return view('Admin.address.edit',['ob'=>$data]);
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
        $data = $request->only('address_consignee','address_consignee_phone','address_detail');
        $row = DB::table('store_address')->where('address_id',$id)->update($data);
        if($row>0){
            return redirect('admin/address')->with('msg','修改成功');
        }else{
            return redirect('admin/address')->with('error','修改失败');
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
        $row = DB::table('store_address')->where('address_id',$id)->delete();
        if($row>0){
            return redirect('admin/address')->with('msg','删除地址成功');
        }else{
            return redirect('admin/address')->with('error','删除地址失败');
        }
    }
}
