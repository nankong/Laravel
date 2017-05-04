<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;

class LinksController extends Controller
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
        $ob = DB::table('store_links');
        //判断是否有搜索条件
        if($request->has('links_name')){
            //获取搜索的条件
            $links_name = $request->input('links_name');
            //添加到将要携带到分页中的数组中
            $where['links_name'] = $links_name;
            //给查询添加where条件
            $ob->where('links_name','like',"%{$links_name}%");
        }
        if($request->has('links_url')){
            //获取搜索的条件
            $links_url = $request->input('links_url');
            //添加到将要携带到分页中的数组中
            $where['links_url'] = $links_url;
            //给查询添加where条件
            $ob->where('links_url','like',"%{$links_url}%");
        }
        //执行分页查询
        $list = $ob->paginate(2);
        return view('Admin.Links.index',['list'=>$list,'where'=>$where]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('Admin.Links.add');
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
            'links_name.required' => '连接名必须填写',
            // 'links_name.max:8' => '连接名长度不得超过8个',
        ];

        $this->validate($request, [
            'links_name' => 'required|max:8',
        ],$message);
        $data = $request->except('_token');
        $id = DB::table('store_links')->insertGetId($data);
        if($id>0){
            return redirect('admin/links')->with('msg','添加成功');
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
        $data = DB::table('store_links')->where('links_id',$id)->first();
        return view('Admin.Links.edit',['ob'=>$data]);
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
        $data = $request->except('_token','_method');
        //dd($data);
        //$data = $request->only('links_name');
        $row = DB::table('store_links')->where('links_id',$id)->update($data);
        if($row>0){
            return redirect('admin/links')->with('msg','修改成功');
        }else{
            return redirect('admin/links')->with('error','修改失败');
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
        $row = DB::table('store_links')->where('links_id',$id)->delete();
        if($row>0){
            return redirect('admin/links')->with('msg','删除成功');
        }else{
            return redirect('admin/links')->with('error','删除失败');
        }
    }

}
