<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Controllers\Upload\UploadController;

use DB;

class GoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $category = DB::table('store_category')->get();
        //保存搜索条件
        $where = '';
        //实例化操作表
        $ob = DB::table('store_goods');
        //判断是否有搜索条件
        if($request->has('goods_id')){
            //获取搜索的条件
            $goods_id = $request->input('goods_id');
            //添加到将要携带到分页中的数组中
            $where['goods_id'] = $goods_id;
            //给查询添加where条件
            $ob->where('goods_id','like',"%{$goods_id}%");
        }
        if($request->has('goods_name')){
            //获取搜索的条件
            $goods_name = $request->input('goods_name');
            //添加到将要携带到分页中的数组中
            $where['goods_name'] = $goods_name;
            //给查询添加where条件
            $ob->where('goods_name','like',"%{$goods_name}%");
        }
        $avalue = DB::table('store_avalue')->get();
        $store_attr = DB::table('store_attr')->get();
        // dd($avalue);
        // dd($ob->get());
        $goods_attr_value = '';
        foreach($ob->get() as $v){
            // dd($v->goods_attr_value);
            $goods_attr_value[] = explode(',',$v->goods_attr_value);
        }
        // dd($goods_attr_value);
        // $goods_attr_value = explode($ob->goods_attr_value,',');
        
        // var_dump ($avalue['avalue_id']);die;
        // for($i=1;$i<=5;$i++){
        // var_dump ($avalue[$i]);
        // }
        // die;
        //执行分页查询
        $list = $ob->paginate(5);
        return view('Admin.Goods.index',['list'=>$list,'where'=>$where,'category'=>$category,'avalue'=>$avalue,'goods_attr_value'=>$goods_attr_value,'store_attr'=>$store_attr]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //查询商品的所有类别
        $category = DB::table('store_category')->get();
        // dd($category);
        return view('Admin.Goods.add',['category'=>$category]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $message = [
            'goods_name.required' => '商品名称必须填写',
            'goods_keywords.required' => '商品关键字必须填写',
            'goods_state.required' => '商品状态必须填写',
            'goods_sale_price.required' => '商品价格必须填写',
            'goods_keywords.max:50' => '商品内容不得超过50',
            'category_id.required' => '商品类别必须填写',
        ];

        $this->validate($request, [
            'goods_name' => 'required|max:50',
             'category_id' => 'required',
             'goods_keywords' => 'required',
             'goods_state' => 'required',
             'goods_sale_price' => 'required',
        ],$message);
        // $upload = new UploadController;
        $data = $request->except('_token','goods_big_pic');
        $data['goods_time'] = time();
        // $data['goods_big_pic'] = $upload->doupload($data['goods_big_pic']);
        // dd($data);
        $id = DB::table('store_goods')->insertGetId($data);
        if($id>0){
            return redirect('admin/goods')->with('msg','添加成功');
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
        $category = DB::table('store_category')->get();
        $data = DB::table('store_goods')->where('goods_id',$id)->first();
        //商品的参数
        $attr = DB::table('store_attr')->get();
        $avalue = DB::table('store_avalue')->get();
        return view('Admin.Goods.edit',['ob'=>$data,'category'=>$category,'attr'=>$attr,'avalue'=>$avalue]);
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
        $upload = new UploadController;
        $data = $request->except('_token','_method');
        // dd($data);
        // var_dump($data['goods_attr_value']);die;
        // dd($data);
        $r = DB::table('store_goods')->where('goods_id',$id)->get();
        // dd($r[0]->goods_big_pic);
        //如果商品表里的pic与传过来的pic如果不一致则需要把原先的图片干掉再重新上传，否则不需要上传
        if($data['goods_big_pic'] != $r[0]->goods_big_pic){
            // $dir = dirname(__FILE__);
            if($r[0]->goods_big_pic != 'default_goods.jpg'){
                $path = public_path('Admin\upload\\'.$r[0]->goods_big_pic);
                // dd($dir);
                // dd($path);
                unlink($path);
            }
            $data['goods_big_pic'] = $upload->doupload($data['goods_big_pic']);
        }else{
             $data = $request->except('_token','_method','goods_big_pic');
             // dd($data);
        }
        $data['goods_time'] = time(); 
        $data['goods_attr_value'] = implode($data['goods_attr_value'],',');
        // dd($data['goods_big_pic']);
        // dd($data);
        $row = DB::table('store_goods')->where('goods_id',$id)->update($data);
        if($row>0){
            return redirect('admin/goods')->with('msg','修改成功');
        }else{
            return redirect('admin/goods')->with('error','修改失败');
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
        $r = DB::table('store_goods')->where('goods_id',$id)->get();
        if($r[0]->goods_big_pic != 'default_goods.jpg'){
            $path = public_path('Admin\upload\\'.$r[0]->goods_big_pic);
            // dd($dir);
            // dd($path);
            unlink($path);
        }
        $row = DB::table('store_goods')->where('goods_id',$id)->delete();
        if($row>0){

            return redirect('admin/goods')->with('msg','删除成功');
        }else{
            return redirect('admin/goods')->with('error','删除失败');
        }
    }

}
