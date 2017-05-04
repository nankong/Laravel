<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class Usercontroller extends Controller
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
        $ob = DB::table('store_user');
        // 判断是否有搜索条件
        if($request->has('user_sex')){
            // 获取搜索的条件
            $sex = $request->input('user_sex');
            // 添加到将要携带到分页中的数组中
            $where['user_sex'] = $sex;
            // 给查询添加where条件
            $ob->where('user_sex',$sex);
        }
        if($request->has('user_username')){
            // 获取搜索的条件
            $name = $request->input('user_username');
            // 添加到将要携带到分页中的数组中
            $where['user_username'] = $name;
            // 给查询添加where条件
            $ob->where('user_username','like',"%{$name}%");

        }

        // 执行分页查询
        $list = $ob->paginate(5);
        return view('Admin.User.index',['list' => $list, 'where' =>$where]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('Admin.User.add');
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
        $data['user_time'] = time();
        $data['user_pass'] = md5($data['user_pass']);
        // var_dump($data);
        // exit;

        $id = DB::table('store_user')->insertGetId($data);
        if($id > 0){
            return redirect('/admin/demo4')->with('msg','添加成功');
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
        $data = DB::table('store_user')->where('user_id',$id)->first();
        return view('Admin.user.edit',['ob' => $data]);
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
        $data = $request->only('user_username','user_sex','user_code');
        $row = DB::table('store_user')->where('user_id',$id)->update($data);
        if($row > 0 ){
            return redirect('admin/demo4')->with('msg','修改成功');
        }else{
            return redirect('admin/demo4')->with('error','修改失败！');
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
        $row = DB::table('store_user')->where('user_id',$id)->delete();
        if($row > 0 ){
            return redirect('admin/demo4')->with('msg','删除成功');
        }else{
            return redirect('admin/demo4')->with('error','删除失败！');
        }
    }
}
