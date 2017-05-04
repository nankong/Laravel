<!DOCTYPE html>
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Language" content="zh-cn">
<meta name='csrf-token' content="{{ csrf_token() }}"> 
<title>登录_华为帐号</title>

<link rel="shortcut icon" href="{{ asset('Home/Ico/favicon.ico') }}" type="image/x-icon"> 

<link href="{{ asset('Home/Css/ec.css') }}" rel="stylesheet" type="text/css"> 
<link href="{{ asset('Home/Css/account.css') }}" rel="stylesheet" type="text/css">
<script type="text/javascript" src="{{ asset('Home/Jquery/jquery-1.7.2.js') }}"></script>
</head>
<body class="login">
<!-- 头部  --> 

<div class="customer-header">
    <div class="g">
         <table cellpadding="0" cellspacing="0">
                <tbody><tr>
                    <td><a href="/"><img src="{{ asset('Home/Images/logo2.png') }}"></a></td>
                    <td style="padding-left:5px;"><img src="{{ asset('Home/Images/split1.png') }}"></td>
                    <td>
                        <span>华为商城</span>
                    </td>
                </tr>
            </tbody></table>
    </div>
</div>
    <div class="g">
        <iframe class="advise" src="" allowtransparency="true" scrolling="no" style="height:0px;position: absolute;width: 550px;top: 10px;left: 60px;overflow: hidden;border: 0px" frameborder="0"></iframe>
        <!--保存上一个url-->
        <input type="hidden" name='preUrl' value="">
        <!--登录 -->
        <div class="login-area">
            <div class="h">
                <h3 class="login-area-marginTop"><span>欢迎登录华为帐号</span></h3>
            </div>
            <div class="b">
                <form action="/home/dologin" method="post" name="myform" autocomplete="off" class="login-form-marginTop" onsubmit="return false;" >
                    {{ csrf_field() }}
                    <div class="form-edit-area">
                        <table border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td><input autocomplete="off" class="text vam" id="login_userName" name="user_username" maxlength="50" tabindex="1" type="text" placeHolder="用户名:6-20位,数字字母组合"></td>
                                </tr>
                                <tr>
                                    <td><input id="login_password" class="text vam" name="user_pass" value="" maxlength="32" tabindex="2" type="password"  placeHolder="密码:(6-32字符)"></td>
                                </tr>
                                 
                                <tr>
                                    <td>
                                        <table>
                                            <tbody><tr>
                                                <td>
                                                    <input autocomplete="off" class="verify vam" id="randomCode" name="" maxlength="5" tabindex="3" type="text" placeholder='不区分大小写'>&nbsp;&nbsp;
                                                </td>
                                                <td>
                                                    <img class="vam pointer" id="randomCodeImg" src="{{ url('/Admin/captch/'.time()) }}" alt="验证码" onclick="this.src='{{ url('/Admin/captch') }}/'+Math.random()" width="130" height="40">
                                                    &nbsp;&nbsp;
                                                </td>
                                                <td>
                                                    <img class="vam pointer" id="randomCodeImg_do"
                                                       src="{{ asset('Home/Images/chg_image.png') }}"  alt="换一张" onclick="$('#randomCodeImg').attr('src','{{ url('/Admin/captch') }}/'+Math.random());">
                                                </td>
                                                
                                                <td>
                                                    <span class="vam" style="margin:0px;" id="randomCodeError"></span>
                                                </td>
                                            </tr>
                                        </tbody></table>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td>
                                        <input class="checkbox vam" id="remember_name" tabindex="4" checked="checked" type="checkbox"><label class="vam" for="remember_name">记住用户名</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <a class="forgot vam" href=""  title="忘记密码？ ">忘记密码？ </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        
                                        <div style="margin-bottom:0px;">
                                        <span class="vam error" id="login_msg" style="margin-bottom:5px;display:block">
                                         
                                        </span></div>
                                        <button class="button-login" id="btnLogin" tabindex="5">登录</button>&nbsp;&nbsp;
                                        
                                        <img class="load" src="{{ asset('Home/Images/loading3.gif') }}">

                                        <div id="msg_notice" style="color:red;float:right;width:150px;height;40px;line-height:40px;border:none;font-size:18px;display:block;"></div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                </form>
                
                <script type="text/javascript">
                    $("#login_userName").keyup(function(){
                        var name=$(this).val();
                        if(/^([\d|[a-z]){6,20}$/i.test(name)){
                            $("#login_msg").html("");
                            mark=1;
                        }else{
                            $("#login_msg").html("用户名不符合要求");  
                            mark=0;
                        }   
                    });
                        
                    $("#login_password").keyup(function(){
                        var pwd=$(this).val();
                        if(/^(\d|[a-z]){6,32}$/i.test(pwd)){
                            $("#login_msg").html("");
                            mark=1;
                        }else{
                            $("#login_msg").html("密码不符合要求");
                            mark=0;
                        }    
                    });

                    $("#randomCode").blur(function(){
                        var code=$(this).val();
                        if(!/^(\d|[a-z]){5}$/i.test(code)){
                            $("#login_msg").html("验证码输入不符合要求");
                            mark=0;
                        }else{
                            $("#login_msg").html("");
                            //ajax验证验证码
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                url:"/home/login/yzmcode",
                                type:"post",
                                async:true,
                                data:{
                                    'code':code,
                                },
                                datatType:'json',
                                success:function(responseText,status,xhr){
                                    console.log(responseText);
                                    if(responseText==1){
                                        // alert("验证码成功");
                                        $("#login_msg").html("验证码输入正确");
                                        mark=1;
                                    }else{
                                        $("#login_msg").html("验证码输入错误请重新输入");
                                        mark=0;
                                    }
                                }
                            });
                        }
                    });

                    $("#btnLogin").click(function(){
                        if(mark==1){
                            var name=$("#login_userName").val();
                            var pwd=$("#login_password").val();
                            // var url=$("input[name=preUrl]").val();
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                            });
                            $.ajax({
                                url:'/home/dologin',
                                type:'post',
                                async:true,
                                // ,'_token':"{{ csrf_token() }}"
                                data:{
                                    'uname':name,
                                    'pwd':pwd
                                },
                                dataType:'json',
                                beforeSend:function(){ 
                                    $(".load").css("height","15");
                                }, 
                                /*success:function(data)
                                {
                                    // alert(data);
                                    // alert(111);
                                    // console.log(111111);
                                    if(data==1){
                                        alert("成功");
                                        console.log(data);
                                        $("#msg_notice").css("display","block");
                                        $("#msg_notice").html("欢迎登录华为商城");
                                        window.location.href="{{ url('/') }}";
                                    }else{
                                        // alert("失败");
                                        alert(data);
                                        console.log(data);
                                        $("#msg_notice").css("display","block");
                                        $("#msg_notice").html("用户名或密码错误");
                                    }
                                    
                                    $(".load").css("height","0");
                                },*/
                                success:function(responseText,status,xhr)
                                {
                                    //0 表示失败 2 登录成功
                                    if(responseText==0){
                                        $("#login_msg").html("用户名或密码错误,登录失败!");
                                    }else if(responseText==2){
                                        //成功就进行跳转
                                        $("#login_msg").html("登录成功!"); 
                                        if(document.referrer=='http://shop.com/home/register'){
                                            window.location.href="{{ url('/') }}";
                                        }else{
                                            window.location.href=document.referrer;
                                        }
                                    }else{
                                        $("#login_msg").html("登录失败!请重新登录!");
                                        console.log(responseText);
                                    }
                                    $(".load").css("height","0");
                                },
                                error:function()
                                {
                                    alert('ajax请求失败');
                                    $(".load").css("height","0");
                                }
                            });
                        }
                    }); 
                </script>
                
                <!-- edit third fastlogin -->
                <span style="color:#666;" class="thirdAccountSpan">使用合作网站帐号登录：</span>
                <span class="alipayLogin" title="支付宝" onclick="thirdAccountLogin(this)"><a href="javascript:void(0);" tourl="/alipay/alipay_auth_authorize.jsp"><s></s></a></span>
        
                <span class="qqLogin" title="QQ" onclick="thirdAccountLogin(this)"><a href="javascript:void(0);" tourl="/qq/authorize.jsp"> <s></s></a></span>
         
                <!-- end edit -->
                
                <p>
                    没有华为帐号？ &nbsp;&nbsp;<a href="{{ url('/home/register') }}" title="免费注册">免费注册</a>
                </p>
                <p style="margin-top:0px; padding-top:0xp;color:#929292;border-top: none">
                    华为帐号可登录华为商城、花粉俱乐部、 应用市场、Cloud+、华为网盘、华为开发者联盟等华为云服务。
                </p>
                
            </div>
        </div>
    </div>
     <div class="hr-60"></div>
<!-- 底部  -->

<div class="customer-footer">
    <div class="g">
        <!--授权  -->
        <div class="warrant-area">
            <p style="text-align: center;height-line:20px;height:20px; "><a style="text-decoration: underline;" target="blank" href="javascript:void(0)" title="《华为帐号服务条款、华为隐私政策》">《华为帐号服务条款、华为隐私政策》</a></p>
            <p style="text-align: center;height-line:20px;height:20px; ">Copyright&nbsp;©&nbsp;2011-2013&nbsp;&nbsp;
华为软件技术有限公司&nbsp;&nbsp;版权所有&nbsp;&nbsp;保留一切权利&nbsp;&nbsp;苏B2-20070200
号&nbsp;|&nbsp;苏ICP备09062682号-9</p>
        </div>
    </div>
</div>

    <div id="layer">
        <div class="mc"></div>
    </div>

</body></html>