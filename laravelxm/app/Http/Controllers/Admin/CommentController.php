<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;

class CommentController extends Controller
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
        $ob = DB::table('store_comment');
        //判断是否有搜索条件
        if($request->has('comment_gid')){
            //获取搜索的条件
            $comment_gid = $request->input('comment_gid');
            //添加到将要携带到分页中的数组中
            $where['comment_gid'] = $comment_gid;
            //给查询添加where条件
            $ob->where('comment_gid','like',"%{$comment_gid}%");
        }
        if($request->has('comment_uid')){
            //获取搜索的条件
            $comment_uid = $request->input('comment_uid');
            //添加到将要携带到分页中的数组中
            $where['comment_uid'] = $comment_uid;
            //给查询添加where条件
            $ob->where('comment_uid','like',"%{$comment_uid}%");
        }
        //执行分页查询
        $list = $ob->paginate(2);
        return view('Admin.Comment.index',['list'=>$list,'where'=>$where]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('Admin.Comment.add');
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
            'comment_body.required' => '评论内容必须填写',
            // 'comment_body.max:50' => '评论内容不得超过50',
            // 'comment_gid.required' => '商品id必须填写',
        ];

        $this->validate($request, [
            'comment_body' => 'required|max:50',
            // 'comment_gid' => 'required',
        ],$message);
        $data = $request->except('_token');
        $data['comment_pubtime'] = time();
        // $uid = DB::table('store_admin')->where('Admin_name',session('Admin_name'))->value('Admin_id');
        $data['comment_uid'] = 1;//$uid;
          // dd($data);
        $id = DB::table('store_comment')->insertGetId($data);
        if($id>0){
            return redirect('admin/comment')->with('msg','添加成功');
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
        $data = DB::table('store_comment')->where('comment_id',$id)->first();
        return view('Admin.Comment.edit',['ob'=>$data]);
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
        $data = $request->only('comment_body');
        // dd($data);
        //$data = $request->only('comment_gid');
        $row = DB::table('store_comment')->where('comment_id',$id)->update($data);
        if($row>0){
            return redirect('admin/comment')->with('msg','修改成功');
        }else{
            return redirect('admin/comment')->with('error','修改失败');
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
        $row = DB::table('store_comment')->where('comment_id',$id)->delete();
        if($row>0){
            return redirect('admin/comment')->with('msg','删除成功');
        }else{
            return redirect('admin/comment')->with('error','删除失败');
        }
    }

}
