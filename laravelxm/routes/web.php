<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// vikin.cc/article/8

// 模板继承的用户管理
Route::group(['prefix' =>'admin','middleware' => 'login'],function(){
	// 后台首页
	Route::resource('/demo3','Admin\Admincontroller');
	// 用户管理
	Route::resource('/demo4','Admin\Usercontroller');
	// 用户退出
	Route::get('/over','Admin\LoginController@over');
	// 管理员管理
	Route::resource('/SuperAdmin','Admin\SuperAdminController');
	// 公告管理
	Route::resource('/notice','Admin\NoticeController');
	// 订单管理
    Route::resource('/order','Admin\OrderController');
    // 收货地址管理
    Route::resource('/address','Admin\AddressController');
    // 网站配置管理
    Route::resource('/config','Admin\ConfigController');
    // 类别管理
	Route::resource('/category','Admin\CategoryController');
	Route::get('/categorySon/{id}','Admin\CategoryController@createSon');
	Route::post('/categorySon','Admin\CategoryController@storeSon');
	// 友情链接管理
	Route::resource('/links','Admin\LinksController');
	// 评论管理
	Route::resource('/comment','Admin\CommentController');
	// 商品管理
	Route::resource('/goods','Admin\GoodsController');
	// 购物车管理
	Route::resource('/temprory','Admin\TemproryController');
	// 收藏管理
	Route::resource('/collect','Admin\CollectController');
	// 回收站管理
	Route::resource('/recover','Admin\RecoverController');
	// 楼层展示
	Route::resource('/indexsale','Admin\IndexsaleController');
});
// 登录
Route::get('admin/login','Admin\LoginController@index');
Route::post('admin/dologin','Admin\LoginController@dologin');
// 验证码
Route::get("Admin/captch/{tmp}",'Admin\LoginController@captch');
// 前台首页
Route::get('/','Home\IndexController@index');

Route::group(['prefix' => 'home'],function(){
	// 个人中心	
	Route::resource('/member','Home\MemberController');

	Route::resource('/personal','Home\PersonalController');

	Route::get('/pwd','Home\PersonalController@pwd');

	Route::get('/account','Home\PersonalController@account');

	Route::resource('/address','Home\AddressController');

	Route::resource('/order','Home\OrderController');

	Route::resource('/comment','Home\CommentController');
	// 前台退出
	Route::get('/quit','Home\LoginController@quit');
	// 修改个人信息
	Route::post('/modifierUser','Home\PersonalController@modper');
	// 添加收货地址
	Route::post('/addAddress','Home\AddressController@addAddress');
	// 删除收货地址
	Route::get('/deladd','Home\AddressController@deladd');
	// 设置默认地址
	Route::post('/defadd','Home\AddressController@defadd');
	// 前台首页分类管理
	Route::get('/category','Home\CategoryController@index');
	// 修改密码
	Route::post('/modpwd','Home\PersonalController@modpwd');
	// 商品排序
	Route::get('/search/{keywords}/order.{ob?}','Home\SearchController@index');
	// 搜索商品
	Route::get('/search/{keywords?}','Home\SearchController@index');
	// 帮助中心
	Route::get('/help',function(){
		return view('Home/Help/index');
	});
	// 如何购买
	Route::get('/help/buy',function(){
		return view('Home/Help/buy');
	});
	// 头部查询订单和购物车
	Route::get('/smallcat/myshop','Home\SmallCatController@myshop');
	// 头部查询购物车
	Route::get('/smallcat/mygoods','Home\SmallCatController@mygoods');
	// 头部删除购物车
	Route::get('/smallcat/delgoods','Home\SmallCatController@delgoods');
	// 网站状态
	Route::get('/config','Home\IndexController@config');
	// 网站维护
	Route::get('/network',function(){
		return view('Home/network');
	});
	// 添加评论
	Route::post('/addcomment','Home\CommentController@addcomment');
	// 确认收货
	Route::post('/yesorder','Home\OrderController@yesorder');

	// 购物车
    Route::resource('/cart/index','Home\CartController');
    // 购物车为空
    Route::resource('/cart/none','Home\CartController');
    // 购物车数据显示
    Route::post('/cart/cartContent','Home\CartController@cartContent');
    // 购物车物品数量改变
    Route::post('/cart/changeGoodsNum','Home\CartController@changeGoodsNum');
    // 删除购物车物品
    Route::post('/cart/carDel','Home\CartController@carDel');
    // 删除多个购物车物品
    Route::post('/cart/carDelNum','Home\CartController@carDelNum');
    // 提交订单页面
    Route::get('/cart/confirmcart/{id}','Home\CartConfirmController@index');
    // 提交订单
    Route::get('/cart/submit/{idd}','Home\SubmitController@index');
    // 付款成功
    Route::get('/cart/dosubmit/{num}','Home\SubmitController@dosubmit');

    // 商品详情
    Route::get('/goodinfo/{id}','Home\GoodinfoController@index');
    // 列表
    Route::get('/list/{id}','Home\ListController@index');
    //热销商品
    Route::get('/hotsale','Home\HotSaleController@index');
    // 添加到购物车
    Route::post('/goodsadd','Home\SmallCatController@doadd');
    // 立即购买
    Route::post('/buy','Home\SmallCatController@buy');
    Route::get('/gobuy','Home\SmallCatController@gobuy');
    // 添加收藏
    Route::post('/collect/add','Home\CollectController@add');
    // 浏览收藏
    Route::post('/collect/index','Home\CollectController@index');
    Route::get('/collect/look','Home\CollectController@look');
    // 删除收藏
    Route::get('/collect/del/{id}','Home\CollectController@del');
	
});
// 前台注册
Route::get('home/register','Home\RegisterController@index');
// 前台登录
Route::get('home/login','Home\LoginController@index');
// 检查新注册用户名知否已存在
Route::post('home/docheck','Home\RegisterController@docheck');
// 执行注册
Route::post('home/doregister','Home\RegisterController@dostore');
// 执行登录
Route::post('home/dologin','Home\LoginController@dologin');
// 验证码验证
Route::post('home/login/yzmcode','Home\LoginController@yzmcode');
// 前台验证登陆
Route::get('home/checklogin','Home\LoginController@checklogin');