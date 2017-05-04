<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;

class RecoverController extends Controller
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
        $ob = DB::table('store_recover');
        //判断是否有搜索条件
        if($request->has('recover_gid')){
            //获取搜索的条件
            $recover_gid = $request->input('recover_gid');
            //添加到将要携带到分页中的数组中
            $where['recover_gid'] = $recover_gid;
            //给查询添加where条件
            $ob->where('recover_gid','like',"%{$recover_gid}%");
        }
        if($request->has('recover_uid')){
            //获取搜索的条件
            $recover_uid = $request->input('recover_uid');
            //添加到将要携带到分页中的数组中
            $where['recover_uid'] = $recover_uid;
            //给查询添加where条件
            $ob->where('recover_uid','like',"%{$recover_uid}%");
        }
        //执行分页查询
        $list = $ob->paginate(2);
        return view('Admin.Recover.index',['list'=>$list,'where'=>$where]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('Admin.Recover.add');
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
            'recover_gid.required' => '商品id必须填写',
            // 'recover_gid.max:50' => '商品id不得超过50',
            // 'recover_gid.required' => '商品id必须填写',
        ];

        $this->validate($request, [
            'recover_gid' => 'required|max:50',
            // 'recover_gid' => 'required',
        ],$message);
        $data = $request->except('_token');
        $data['recover_time'] = time();
          // dd($data);
        $id = DB::table('store_recover')->insertGetId($data);
        if($id>0){
            return redirect('admin/recover')->with('msg','添加成功');
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
        $data = DB::table('store_recover')->where('recover_id',$id)->first();
        return view('Admin.Recover.edit',['ob'=>$data]);
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
        $data = $request->only('recover_gid');
        // dd($data);
        //$data = $request->only('recover_gid');
        $row = DB::table('store_recover')->where('recover_id',$id)->update($data);
        if($row>0){
            return redirect('admin/recover')->with('msg','修改成功');
        }else{
            return redirect('admin/recover')->with('error','修改失败');
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
        $row = DB::table('store_recover')->where('recover_id',$id)->delete();
        if($row>0){
            return redirect('admin/recover')->with('msg','删除成功');
        }else{
            return redirect('admin/recover')->with('error','删除失败');
        }
    }

}
