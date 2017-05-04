<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class store_admin extends Model
{   
     //自定义用户表名
     protected $table = 'store_admin';
    //
    public function checkUser($request)
    {   
        
    	// 获取用户登录的用户名
    	$name = $request->input('name');
    	// 通过用户名查询数据库有没有这个用户
    	$ob = $this->where('admin_name',$name)->first();
    	// 如果查出有用户，则验证密码
    	if($ob){
    		if($request->input('admin_pass') == $ob->password){
    			return $ob;
    		}else{
    			return null;
    		}
    	}else{
    		return null;
    	}
    }
}
