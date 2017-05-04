@php
	header('content:text/html;charset=utf-8');
@endphp
<!--头部粉红色条-->
<div class="qq-caibei-bar hide"  id="caibeiMsg">
    <div class="layout">
        <div class="qq-caibei-bar-tips"  id="HeadShow"></div>
        <div class="qq-caibei-bar-userInfo"  id="ShowMsg"></div>
    </div>
</div>

<!--头部的粉红色条-->
<div class="shortcut">
    <div class="layout">     
    <span id="unlogin_status">        
       <a href="{{ url('/home/login') }}" rel="nofollow">[登录]</a><a  href="{{ url('/home/register') }}" rel="nofollow">[注册]</a>
    </span>
    <span id="login_status" class="hide">欢迎您，<a href="{{ url('home/member') }}" id="customer_name"  rel="nofollow" timetype="timestamp"></a>
    [<a href="{{ url('/home/quit') }}">退出</a>]</span>
    <b>|</b><a  href="{{ url('home/order') }}"  rel="nofollow"  timetype="timestamp">我的订单</a><span  id="preferential"></span><b>|</b><a  href="{:U('Help/vmall')}"  rel="nofollow"  class="red">帮助中心</a><b>|</b><a  href="javascript:return  false;"  >华为商城手机版</a>
    </div>
</div>

<script type="text/javascript">
// 顶部粉红条 ajax进行处理结果
$(function(){
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
                    // alert(1111);
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
