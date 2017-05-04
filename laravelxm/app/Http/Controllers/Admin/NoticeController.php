<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class NoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        // dd($request->input());

        //保存搜索条件
        $where = '';
        // 实例化操作表
        $ob = DB::table('store_notice');
        // 判断是否有搜索条件
        if($request->has('notice_title')){
            // 获取搜索的条件
            $title = $request->input('notice_title');
            // 添加到将要携带到分页中的数组中
            $where['notice_title'] = $title;
            // 给查询添加where条件
            $ob->where('notice_title','like',"%{$title}%");
        }
        // 执行分页查询
        $list = $ob->paginate(5);
        return view('Admin.notice.index',['list' => $list, 'where' =>$where]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('Admin.notice.add');
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
       
        $data = $request->except('_token');
        $data['notice_time'] = time($data['notice_time']);
        // var_dump($data);
        // exit;

        $id = DB::table('store_notice')->insertGetId($data);
        if($id > 0){
            return redirect('/admin/notice')->with('msg','添加成功');
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
        $data = DB::table('store_notice')->where('notice_id',$id)->first();
        return view('Admin.notice.edit',['ob' => $data]);
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
        $data = $request->only('notice_title','notice_content','notice_type');
        $row = DB::table('store_notice')->where('notice_id',$id)->update($data);
        if($row > 0 ){
            return redirect('admin/notice')->with('msg','修改成功');
        }else{
            return redirect('admin/notice')->with('error','修改失败！');
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
        $row = DB::table('store_notice')->where('notice_id',$id)->delete();
        if($row > 0 ){
            return redirect('admin/notice')->with('msg','删除成功');
        }else{
            return redirect('admin/notice')->with('error','删除失败！');
        }
    }
}
