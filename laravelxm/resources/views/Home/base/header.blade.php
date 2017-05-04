<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        @yield('title')
        <meta name='csrf-token' content="{{ csrf_token() }}"> 
        <link href="{{ asset('Home/Css/ec.core.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('Home/Css/mainn.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('Home/Css/person/ec.core.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('Home/Css/person/main.css') }}" rel="stylesheet" type="text/css">
        <script src="{{ asset('Home/Css/jsapi.js') }}"  namespace="ec"></script>
        <script src="{{ asset('Home/Js/jquery-1.4.4.min.js') }}" ></script>
        <script src="{{ asset('Home/Js/ec.core.js') }}" ></script> 
        <script src="{{ asset('Home/Js/ec.business.js') }}" ></script> 
        <link rel="shortcut icon" href="{{ asset('Home/Ico/favicon.ico') }}">
        <script src="{{ asset('Home/Js/base.js') }}"></script>
        <style>
        .pagination{
            float:right;
        }
        .pagination li{
            float:left;
            font-size:15px;
            width:20px;
            height:20px;
            border:1px solid #eee;
            border-radius:20px;
            margin:5px;
            text-align:center;
        }
        </style>
    </head>
    @yield('bodycss')      
    <script src="{{ asset('Home/Jquery/jquery-1.7.2.js') }}"></script>
    <div  class="qq-caibei-bar hide"  id="caibeiMsg">
        <div  class="layout">
            <div  class="qq-caibei-bar-tips"  id="HeadShow"></div>
            <div  class="qq-caibei-bar-userInfo"  id="ShowMsg"></div>
        </div>
    </div>
    <div  class="shortcut">
        <div  class="layout">     
        <span id="unlogin_status">        
           <a  href="{{ url('/home/login') }}"  rel="nofollow">[登录]</a><a  href="{{ url('/home/register') }}"  rel="nofollow">[注册]</a>          
        </span>
        <span  id="login_status"  class="hide">欢迎您，<a  href="{{ url('home/member') }}"  id="customer_name"  rel="nofollow"  timetype="timestamp"></a>
        [<a  href="{{ url('/home/quit') }}">退出</a>]</span>
        <b>|</b><a  href="{{ url('/home/order') }}"  rel="nofollow"  timetype="timestamp">我的订单</a><span  id="preferential"></span><b>|</b><a  href="{{ url('/home/help') }}"  rel="nofollow"  class="red">帮助中心</a><b>|</b><a  href="javascript:return  false;"  >华为商城手机版</a>
        </div>
    </div>
    <script type="text/javascript">
        // 顶部粉红条 ajax进行处理结果
        $(function(){
            $.ajax({
                url:'/home/config',
                type:'GET',
                dataType:'json',
                success:function(responseText,status,xhl){
                    // console.log(responseText);
                    if(responseText[0] !== 1){
                        window.location.href='/home/network'
                    }
                },
                error:function(){
                    // console.log(111);
                },
                timeout:60*1000,
            });
            $.ajax({
                url:'/home/checklogin',
                type:'GET',
                dataType:'json',
                success:function(responseText,status,xhr){
                // console.log(responseText);
                if(status=="success"){
                     if(responseText.login_status==1){
                        $("#login_status").removeClass('hide');
                        $("#login_status #customer_name").html(responseText.user_name);
                        $("#unlogin_status").addClass('hide');
                    }else{
                        $("#login_status").addClass('hide');
                        $("#unlogin_status").removeClass('hide');
                    }                  
                }else{
                    $("#login_status").addClass('hide');
                    $("#unlogin_status").removeClass('hide');                  
                }           
                },              
                error:function(){
                $("#login_status").addClass('hide');
                $("#unlogin_status").removeClass('hide');
                },
                timeout:60*1000,  
            });
        });
    </script>
    <script  src="{{ asset('Home/Js/base.js') }}"></script>
    <div  class="top-banner"  id="top-banner-block"></div>
    <header  class="header">
        <div  class="layout">           
            <div  class="logo"><a  href="{{ url('/') }}"  title="Vmall.com - 华为商城"><img  src="{{ asset('Home/Images/newLogo.png') }}"  alt="Vmall.com - 华为商城"></a></div>            
            <div  class="searchBar">                
                <div  class="searchBar-key">
                    <b>热门搜索：</b>                   
                    <a  href="/home/search/畅玩版"  target="_blank">畅玩版</a>                     
                    <a  href="/home/search/荣耀3C"  target="_blank">荣耀3C</a>
                    <a  href="/home/search/X1"  target="_blank">X1</a>
                    <a  href="/home/search/P7"  target="_blank">华为P7</a>
                    <a  href="/home/search/荣耀立方"  target="_blank">荣耀立方</a>
                </div>
                <div  class="searchBar-form"  id="searchBar-area">  
                    <form  method="get"  action="" onsubmit="return false;">
                        <input  type="text"  class="text"  maxlength="100"  id="search_kw"  style="z-index: 1;"  autocomplete="off"  placeholder="请输入搜索关键字" style="height:18px;">   
                        <input  type="submit"  class="button"  value=" " id="submit_go">
                        <input  type="hidden"  id="default-search"  value="荣耀6">
                    </form> 
                </div>
            </div>
            <script type="text/javascript">
               $(function(){
                  var url="/home/search";               
                  $("#submit_go").click(function(){                  
                      var search_kw=$("#search_kw").val();                       
                      if(search_kw.length==0){
                           alert('搜索关键字不能为空');                    
                      }else{
                         window.location.href=url+'/'+search_kw;                     
                      }               
                  });                      
               });              
            </script>                           
            <div  class="header-toolbar">           
                <div  class="header-toolbar-item"  id="header-toolbar-imall">                   
                    <div  class="i-mall">
                         <!------------自己的商城---------------->
                        <div  class="h"><a  href="{{ url('home/member') }}"  rel="nofollow"  timetype="timestamp">我的商城</a>                     
                        <i></i><s></s><u></u></div> 
                        <div  class="b"  id="header-toolbar-imall-content">
                            <div  class="i-mall-prompt"  id="cart_unlogin_info" style="display:block;">
                                <p>你好，请&nbsp;&nbsp;<a  href="{{ url('/home/login') }}"  rel="nofollow">登录</a> / <a  href="{{ url('/home/register') }}"  rel="nofollow">注册</a></p>  
                            </div>
                            <div class="i-mall-prompt" id="cart_login_info" style="display:none">
                                <p><a href="{{ url('home/member') }}" id="cart_memeber"></a><em class="vip-state" id="vip-info">&nbsp;&nbsp;&nbsp;&nbsp;<a href="{{ url('home/member') }}" title="VMALL V0会员" id="vip-Active"><i class="icon-vip-level-0"></i></a></em></p>
                            </div> 
                            <div  class="i-mall-uc "  id="cart_nlogin_info">
                                <ul>
                                     <!-----------代付款和-------------->
                                    <li><a  href="{{ url('home/order') }}"  timetype="timestamp">待付款</a><span  id="toolbar-orderWaitingHandleCount">0</span></li>
                                    <li><a  href="{{ url('home/comment') }}"  timetype="timestamp">待评论</a><span  id="toolbar-notRemarkCount">0</span></li>
                                    <!------------代付款------------>
                                </ul>
                            </div>  
                            <div  class="i-mall-uc ">
                                <p><br></p>
                            </div>
                        </div>
                    </div>
                </div>
    <script type="text/javascript">
        $(function(){     
            $.ajax({
                url:"/home/smallcat/myshop",
                type:'GET',
                dataType:'json',
                success:function(responseText,status,xhr){
                    // console.log(responseText);
                    if(status=='success'){      
                        if(responseText.login_status==1){   
                            $("#cart_login_info").show();
                            $("#cart_unlogin_info").hide();
                            var user_name=responseText.user_name;
                            $("#cart_login_info #cart_memeber").html(responseText.user_name);
                            //计算用户的级别
                            var ico_user_level="icon-vip-level-0";
                            switch(responseText.user_level){
                                case 5: ico_user_level="icon-vip-level-5";break;
                                case 4: ico_user_level="icon-vip-level-4";break;
                                case 3: ico_user_level="icon-vip-level-3";break;
                                case 2: ico_user_level="icon-vip-level-2";break;
                                case 1: ico_user_level="icon-vip-level-1";break;
                                case 0: ico_user_level="icon-vip-level-0";break;
                                default:ico_user_level="icon-vip-level-0";
                            }
                            $("#cart_login_info #vip-Active").find('i').addClass('ico_user_level');
                            $("#toolbar-orderWaitingHandleCount").html(responseText.unpay_count);
                            $("#member-unpayCount").html(responseText.unpay_count);
                            $("#toolbar-notRemarkCount").html(responseText.uncomment_count); 
                            $("#member-notRemarkCount").html(responseText.uncomment_count);  
                        }else{
                            $("#cart_unlogin_info").show();
                            $("#cart_login_info").hide();
                        }
                    }else{
                        $("#cart_unlogin_info").show();
                        $("#cart_login_info").hide();  
                    } 
                }, 
                error:function(){
                    $("#cart_unlogin_info").show();
                    $("#cart_login_info").hide();
                }, 
                timeout:60*1000,           
            });     
        }); 
    </script>                          
                <div  class="header-toolbar-item"  id="header-toolbar-minicart">    
                    <div class="minicart">
                        <div class="h" id="header-toolbar-minicart-h"><a href="{{ url('home/cart/index') }}" rel="nofollow" timetype="timestamp">我的购物车<span><em id="header-cart-total">0</em><b></b></span></a><i></i><s></s><u></u></div>
                            <div style="display:block;" class="b" id="header-toolbar-minicart-content">
                            <div style="display:block;" class="minicart-pro-empty" id="minicart-pro-empty">
                                <span class="icon-minicart">您的购物车是空的，赶紧选购吧！</span>
                            </div>  
                            <div style="display:none;" id="minicart-pro-list-block">
                            <ul class="minicart-pro-list" id="minicart-pro-list"><!--microCartList start-->
                            <!--microCartList end-->
                            </ul>
                            </div>
                            <div style="display:none;" class="minicart-pro-settleup" id="minicart-pro-settleup">
                                <p>共<em id="micro-cart-total">1</em>件商品</p>
                                <p>共计<b id="micro-cart-totalPrice">¥&nbsp;<span>2888.00<span></b></p>
                                <a class="button-minicart-settleup" href="{{ url('home/cart/index') }}">去结算</a>
                            </div>      
                        </div>
                    </div>
                </div>
    <script type="text/javascript">
        //购物进行ajax处理
        $(function(){
            //鼠标移入移除事件
            $("#header-toolbar-minicart-content").hide();
            $("#header-toolbar-minicart-h").hover(function(){
                $("#header-toolbar-minicart-content").show(); 
            },function(){
                $("#header-toolbar-minicart-content").hide();
            }); 
            $("#header-toolbar-minicart-content").hover(function(){
                $(this).show();
              
            },function(){
                $(this).hide();
            }); 
        //ajax查询数量和商品  
        do_cat();     
        function do_cat(){
            $.ajax({ 
                url:"/home/smallcat/mygoods",
                type:'GET',
                dataType:'json',
                success:function(responseText,status,xhr){
                    console.log(responseText);
                    if(status=="success"){
                        if(responseText.cat_status==1){
                            $("#header-cart-total").html(responseText.content.total_nums);
                            $("#minicart-pro-empty").hide();
                            $("#minicart-pro-list-block").show();
                            $("#minicart-pro-list-block #minicart-pro-list").html(responseText.info);
                            $("#minicart-pro-settleup").show();
                            $("#minicart-pro-settleup #micro-cart-total").html(responseText.content.total_nums);
                            $("#minicart-pro-settleup #micro-cart-totalPrice").find('span').html(responseText.content.total_price.toFixed(2));
                             
                        }else{
                        $("#header-cart-total").html('0');
                        $("#minicart-pro-list-block").hide();
                        $("#minicart-pro-settleup").hide();
                        $("#minicart-pro-empty").show(); 
                        } 
                    }else{
                    $("#header-cart-total").html('0');
                    $("#minicart-pro-list-block").hide();
                    $("#minicart-pro-settleup").hide();
                    $("#minicart-pro-empty").show(); 
                    }   
                },
                error:function(){
                    $("#header-cart-total").html('0');
                    $("#minicart-pro-list-block").hide();
                    $("#minicart-pro-settleup").hide();
                    $("#minicart-pro-empty").show();
                },
                timeout:60*1000, 
            });
        } 
        //事件委托的形式添加事件
        $("#minicart-pro-list").on('click',".icon-minicart-del",function(){
            var goods_id=$(this).next('input').val();
            var parent_li=$(this).closest('li');
            //ajax的形式删除元素
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"/home/smallcat/delgoods",
                type:'POST',
                data:{
                'goods_id':goods_id,
                },
                dataType:'json',
                success:function(responseText,status,xhr){
                    console.log(responseText);
                    if(status=='success'){
                        //返回1 说明session 中删除成功!
                        if(responseText.del_status==1){
                            //删除此条信息   
                            parent_li.remove();
                            //修改金额和总数量
                            $("#header-cart-total").html(responseText.total_num);
                            $("#minicart-pro-settleup #micro-cart-total").html(responseText.total_num);
                            $("#minicart-pro-settleup #micro-cart-totalPrice").find('span').html(responseText.total_money.toFixed(2));
                            var lis=$("#minicart-pro-list li").size(); 
                            if(lis<=0){
                            $("#header-cart-total").html('0');
                            $("#minicart-pro-list-block").hide();
                            $("#minicart-pro-settleup").hide();
                            $("#minicart-pro-empty").show();
                             
                            }else{
                                                     
                            }                       
                        }
                    } 
                }  
            });    
        });      
    });
    </script>                           
            </div>
        </div>          
    </header>   <textarea  id="micro-cart-tpl"  class="hide">
    </textarea>
    @yield('body')
    <!--口号-20121025 -->
    <div class="slogan">
        <ul>
            <li class="s1"><i></i>500强企业&nbsp;品质保证</li>
            <li class="s2"><i></i>7天退货&nbsp;15天换货</li>
            <li class="s3"><i></i>200元起免运费</li>
            <li class="s4"><i></i>448家维修网点&nbsp;全国联保</li>
        </ul>
    </div><!--口号-end -->
    <!--服务-20121025 -->
    <div class="service">
            <dl class="s1">
                <dt><i></i>帮助中心</dt>
                <dd>
                    <ol>        
                        <li><a   href="javascript:void(0)">购物指南</a></li>
                        <li><a   href="javascript:void(0)">配送方式</a></li>
                        <li><a   href="javascript:void(0)">支付方式</a></li>
                        <li><a   href="javascript:void(0)">常见问题</a></li>
                    </ol>
                </dd>
            </dl>
            <dl class="s2">
                <dt><i></i>售后服务</dt>
                <dd>
                    <ol>
                        <li><a target="_blank" href="javascript:void(0)">保修政策</a></li>
                        <li><a target="_blank" href="javascript:void(0)">退换货政策</a></li>
                        <li><a target="_blank" href="javascript:void(0)">退换货流程</a></li>
                        <li><a target="_blank" href="javascript:void(0)">手机寄修服务</a></li>
                    </ol>
                </dd>
            </dl>
            <dl class="s3">
                <dt><i></i>技术支持</dt>
                <dd>
                    <ol>        
                        <li><a   href="javascript:void(0)">售后网点</a></li>
                        <li><a   href="javascript:void(0)">常见问题</a></li>
                        <li><a   href="javascript:void(0)">产品手册</a></li>
                        <li><a   href="javascript:void(0)">软件下载</a></li>
                    </ol>       
                </dd>
            </dl>
            <dl class="s4">
                <dt><i></i>关于商城</dt>
                <dd>
                    <ol>
                        <li><a   href="javascript:void(0)">公司介绍</a></li>
                        <li><a   href="javascript:void(0)">华为商城简介</a></li>
                        <li><a   href="javascript:void(0)">联系客服</a></li>
                        <li><a   href="javascript:void(0)">商务合作</a></li>
                    </ol>
                </dd>
            </dl>
            <dl class="s5">
                <dt><i></i>关注我们</dt>
                <dd>
                    <ol>
                        <li><a class="sina" href="javascript:void(0)" target="_blank">新浪微博</a></li>
                        <li><a class="qq" href="javascript:void(0)" target="_blank">腾讯微博</a></li>
                        <li><a class="huafen" href="javascript:void(0)" target="_blank">花粉社区</a></li>
                        <li><a href="javascript:void(0)" >商城手机版</a></li>
                    </ol>
                </dd>
            </dl>
    </div>
    <!--服务-end -->

    <!--在线客服-->
    <div style="top: 230px; left: 1301px; z-index: 500; position: fixed;" class="hungBar" id="tools-nav">
        <a style="opacity: 1;" title="返回顶部" class="hungBar-top" href="#" id="hungBar-top">返回顶部</a>
    </div>
    <div id="globleParameter" class="hide" context="" stylepath="http://res.vmall.com/20140826/css" scriptpath="http://res.vmall.com/20140826/js" imagepath="http://res.vmall.com/20140826/images" mediapath="http://res.vmall.com/pimages/"></div>
    <!--底部 -->
    <footer class="footer">
        <!-- 20130902-底部-友情链接-start -->
        <div class="footer-otherLink">
            <p>热门<a href="javascript:void(0)" >华为手机</a>：<a href="javascript:void(0)" target="_blank">华为Mate7</a> | <a href="javascript:void(0)" target="_blank">荣耀3C畅玩版</a> | <a href="javascript:void(0)" target="_blank" style="line-height:1.5;">荣耀6</a><span style="line-height:1.5;"> | </span><a href="javascript:void(0)" target="_blank" style="line-height:1.5;">荣耀3c</a><span style="line-height:1.5;"> | </span></p><p><br></p>
        </div>
    </footer>
    </body>
</html>