<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;

class CollectController extends Controller
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
        $ob = DB::table('store_collect');
        //判断是否有搜索条件
        if($request->has('collect_gid')){
            //获取搜索的条件
            $collect_gid = $request->input('collect_gid');
            //添加到将要携带到分页中的数组中
            $where['collect_gid'] = $collect_gid;
            //给查询添加where条件
            $ob->where('collect_gid','like',"%{$collect_gid}%");
        }
        if($request->has('collect_uid')){
            //获取搜索的条件
            $collect_uid = $request->input('collect_uid');
            //添加到将要携带到分页中的数组中
            $where['collect_uid'] = $collect_uid;
            //给查询添加where条件
            $ob->where('collect_uid','like',"%{$collect_uid}%");
        }
        //执行分页查询
        $list = $ob->paginate(2);
        return view('Admin.Collect.index',['list'=>$list,'where'=>$where]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('Admin.Collect.add');
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
            'collect_gid.required' => '收藏id必须填写',
            // 'collect_gid.max:50' => '收藏id不得超过50',
            // 'collect_gid.required' => '商品id必须填写',
        ];

        $this->validate($request, [
            'collect_gid' => 'required|max:50',
            // 'collect_gid' => 'required',
        ],$message);
        $data = $request->except('_token');
        $data['collect_time'] = time();
        // $uid = DB::table('store_admin')->where('Admin_name',session('Admin_name'))->value('Admin_id');
        $data['collect_uid'] = 1;//$uid;
          // dd($data);
        $id = DB::table('store_collect')->insertGetId($data);
        if($id>0){
            return redirect('admin/collect')->with('msg','添加成功');
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
        $data = DB::table('store_collect')->where('collect_id',$id)->first();
        return view('Admin.Collect.edit',['ob'=>$data]);
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
        $data = $request->only('collect_gid');
        // dd($data);
        //$data = $request->only('collect_gid');
        $row = DB::table('store_collect')->where('collect_id',$id)->update($data);
        if($row>0){
            return redirect('admin/collect')->with('msg','修改成功');
        }else{
            return redirect('admin/collect')->with('error','修改失败');
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
        $row = DB::table('store_collect')->where('collect_id',$id)->delete();
        if($row>0){
            return redirect('admin/collect')->with('msg','删除成功');
        }else{
            return redirect('admin/collect')->with('error','删除失败');
        }
    }

}
