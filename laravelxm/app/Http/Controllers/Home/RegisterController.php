<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;

class RegisterController extends Controller
{
    //
    public function index()
    {
        return view('Home.register');
    }

    public function docheck(Request $request)
    {
        // echo 1;
        $num = DB::table('store_user')->where('user_username',$request->input('name'))->first();
        if($num){
            $status=1;
        }else{
            $status=0;
        }
        echo $status;
    }

    public function dostore(Request $request)
    {
        $data = array();
        $data['user_username'] = $request->input('name');
        $data['user_pass'] = md5($request->input('pwd'));
        $data['user_time'] = time();
        // echo json_encode($data);
        $id = DB::table('store_user')->insertGetId($data);
        if($id > 0){
            $status=1;
        }else{
            $status=0;
        }
        echo $status;
    }

}
