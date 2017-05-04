<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB,Session;

class CategoryController extends Controller
{
    public $uid;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $parents =  DB::table('store_category')->where('category_upid','=',0)->orderBy('category_id','desc')->get();
        // echo 1;
        // echo json_encode($parents);
        // echo $parents
        $parstr = json_encode($parents);
        $parents = json_decode($parstr, true);
        // echo $parents;
        $child_category=array();
        foreach($parents as $p){
            $child = DB::table('store_category')->where('category_upid', $p['category_id'])->get();
            foreach($child as $v){
                $child_category[] = $v->category_id;
            }
        }
        // echo $child_category;
        // foreach($child_category as $child)
        // {
        //     echo $child;
        // }
        $str='';
        foreach($parents as $p){
            $str.="<li><h3><a  href='/home/list/{$p['category_id']}'><span>{$p['category_name']}</span></a></h3>";
            foreach($child_category as $child){
                $v = DB::table('store_category')->where('category_id', $child)->first();
                // echo $v->category_upid;exit;
                if($v->category_upid == $p['category_id']){
                    $str.="<a  href='/home/list/{$v->category_id}'><span>{$v->category_name}</span></a>";
                }
            }
            $str.="</li>";
        }
        echo json_encode($str);
        // $str='';
        // foreach($parents as $p){
        //     $str.="<li><h3><a  href='/list/{$p['category_id']}'><span>{$p['category_name']}</span></a></h3>";
        //     // foreach($child_category as $child){
        //         $child = DB::table('store_category')->where('category_upid', $p['category_id'])->get();

        //     foreach($child as $v)
        //         // $v = DB::table('store_category')->where('category_id', $child)->first();
        //         // echo $v->category_id;exit;
        //         if($v->category_upid == $p['category_id']){
        //             $str.="<a  href='/list/{$v->category_id}'><span>{$v->category_name}</span></a>";
        //         }
        //     // }
        //     $str.="</li>";
        // }
    }

   
}
