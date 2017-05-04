<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;

class CategoryController extends Controller
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
        $ob = DB::table('store_category');
        //判断是否有搜索条件
        if($request->has('category_name')){
            //获取搜索的条件
            $category_name = $request->input('category_name');
            //添加到将要携带到分页中的数组中
            $where['category_name'] = $category_name;
            //给查询添加where条件
            $ob->where('category_name','like',"%{$category_name}%");
        }
        //执行分页查询
        $list = $ob->paginate(5);
        return view('Admin.Category.index',['list'=>$list,'where'=>$where]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('Admin.Category.add');
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
        $message = [
            'category_name.required' => '类别名必须填写',
        ];

        $this->validate($request, [
            'category_name' => 'required|max:8',
        ],$message);
        
        $data = $request->except('_token');
        $id = DB::table('store_category')->insertGetId($data);
        if($id>0){
            return redirect('admin/category')->with('msg','添加成功');
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
        $data = DB::table('store_category')->where('category_id',$id)->first();
        return view('Admin.category.edit',['ob'=>$data]);
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
        $data = $request->only('category_name');
        $row = DB::table('store_category')->where('category_id',$id)->update($data);
        if($row>0){
            return redirect('admin/category')->with('msg','修改成功');
        }else{
            return redirect('admin/category')->with('error','修改失败');
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
        $list = DB::table('store_category')->where('category_upid',$id)->get();
        if(count($list)>0){
            return redirect('admin/category')->with('error','要删除此类必须先删除此类下的子类');
        }

        $row = DB::table('store_category')->where('category_id',$id)->delete();
        if($row>0){
            return redirect('admin/category')->with('msg','删除成功');
        }else{
            return redirect('admin/category')->with('error','删除失败');
        }
    }

    public function createSon($id)
    {
        $list = DB::table('store_category')->where('category_id',$id)->first();
        return view('Admin.category.addSon',['list' => $list]);
    }

    public function storeSon(Request $request)
    {
        $data = $request->except('_token');
        //先找到父路径，拼接子类路径
        $par = DB::table('store_category')->where('category_id',$request->input('category_upid'))->first();

        $data['category_path'] = $par->category_path.','.$data['category_upid'];
        // dd($data);
        $id = DB::table('store_category')->insertGetId($data);
        if($id>0){
            return redirect('admin/category')->with('msg','添加子类成功');
        }
    }
}
