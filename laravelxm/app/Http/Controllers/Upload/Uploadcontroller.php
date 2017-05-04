<?php

namespace App\Http\Controllers\Upload;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UploadController extends Controller
{
    //
    public function index()
    {
    	return view('Upload.upload');
    }
    // dd(11111111);
    public function doupload($data)
    {
        // dd($r);
    	// $data = $r->file('mypic');
        //dd($data->getClientOriginalName());
    	// for ($i=0; $i < count($data); $i++) { 
    	// 	$ext = $data[$i]->getClientOriginalExtension();
    	// 	$filename = time().rand('1000','9999').'.'.$ext;
    	// 	$data[$i]->move('./admin/upload',$filename);
    	// 	if($data[$i]->getError()>0){
    	// 		echo "{$i}下标的图片上传失败";
    	// 	}else{
    	// 		echo "<img src='./admin/upload/{$filename}' width='200' height='200'>";
    	// 	}
    	
    	// 判断是否有文件上传
    	// if($r->hasFile('mypic')){
    		// 判断上传文件是否有效
    		// if($r->file('mypic')->isValid()){

                // $dd = $data->getError();//错误号
                // dd($dd);
                // if($dd == 4){ return $data['goods_big_pic'];}
    			// 获取上传文件的后缀名
    			$ext = $data->getClientOriginalExtension();
    			// 拼接文件名
    			$picname = time().rand('1000','9999').'.'.$ext;
    			// 移动临时文件，生成新文件到指定目录下
    			$data->move('./admin/upload',$picname);
    			if($data->getError()>0){
    				return '上传失败';
    			}else{
    				return $picname;
    				// echo "<img src='./admin/upload/{$picname}' height='200' width='200'>";
    			}
    		// }
    	// }
    	
    	// $dd = $data->getClientOriginalName();//源文件名
    	// $dd = $data->getClientOriginalExtension();//后缀名
    	// $dd = $data->getClientMimeType();//文件的类型
    	// $dd = $data->getClientSize();//获取文件的大小
    	// $dd = $data->getError();//错误号
    }
}
