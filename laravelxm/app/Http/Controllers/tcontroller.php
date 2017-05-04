<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gregwar\Captcha\CaptchaBuilder;

class tcontroller extends Controller
{
    //
    public function captch()
    {
	    $builder = new CaptchaBuilder;
	    $builder->build(150,32,null);
	    //Session::set('phrase',$builder->getPhrase()); //存储验证码
	    return response($builder->output())->header('Content-type','image/jpeg');
	}
}
