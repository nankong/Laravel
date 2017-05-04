
@extends('Home.base.parent')
@section('title')
<title>注册_帮助中心_华为商城</title>
<link href="{{ asset('Home/Css/help.ec.core.css') }}"  rel="stylesheet" type="text/css">
<link href="{{ asset('Home/Css/help.main.css') }}"  rel="stylesheet" type="text/css">
@endsection
@section('bodycss')
@endsection
@section('body')
<div class="hr-10"></div>
<div class="g">
	<!--面包屑 -->
	<div class="breadcrumb-area icon-breadcrumb fcn">您最近的位置：<a href="#" title="首页">首页</a>&nbsp;>&nbsp;<a href="#" title="帮助中心">帮助中心</a>&nbsp;>&nbsp;<b>货到付款</b></div>
</div>
<div class="hr-15"></div>
<div class="g">
    <div class="fr u-4-5">
    	
        <!--帮助中心-内容 -->
        <div class="help-detail-area">
			<div class="h">
				<h3>注册</h3>
			</div>
        	<div class="b"><p>目前华为商城有两种账户注册方式：电子邮箱注册与手机号码注册。注册成功后您便获得了华为商城的账号，您就可以使用此账号登录华为商城购物了。</p>

  <p><b>（一）电子邮箱注册</b> &nbsp;&nbsp;<a class="button-style-5" target="_blank" href="javascript:if(confirm('http://hwid1.vmall.com:8080/oauth2/portal/regbymail.jsp?service=http%3A%2F%2Fwww.vmall.com%2Faccount%2Fcaslogin&loginChannel=26000000&reqClientType=26  \n\n�ļ���δ�� Teleport Pro ȡ�أ���Ϊ �������·��������ʼ��ַ�����õķ�Χ��  \n\n��Ҫ�ӷ������ϴ�����'))window.location='http://hwid1.vmall.com:8080/oauth2/portal/regbymail.jsp?service=http%3A%2F%2Fwww.vmall.com%2Faccount%2Fcaslogin&loginChannel=26000000&reqClientType=26'" tppabs="http://hwid1.vmall.com:8080/oauth2/portal/regbymail.jsp?service=http%3A%2F%2Fwww.vmall.com%2Faccount%2Fcaslogin&loginChannel=26000000&reqClientType=26"title="去注册"><span>去注册</span></a></p>



<p>1.&nbsp;打开华为商城网站（<a href="javascript:if(confirm('http://www.vmall.com/  \n\n�ļ���δ�� Teleport Pro ȡ�أ���Ϊ �������·��������ʼ��ַ�����õķ�Χ��  \n\n��Ҫ�ӷ������ϴ�����'))window.location='http://www.vmall.com/'" tppabs="http://www.vmall.com/" target="_blank" title="华为商城">www.vmall.com</a>），点击网页顶部“免费注册”，商城网页会自动进入注册页面；</p>
<p style="text-align:center;"></p>
 
<p>2.&nbsp;在注册页面，点击“电子邮箱注册”；</p>
<p style="text-align:center;"></p>
<p>3.&nbsp;按照网页提示，填写您常用的电子邮箱，设置账号密码，输入验证码；选中“同意华为商城注册协议”，点击“立即注册”（如下图所示）；</p>
  <p style="text-align:center;"></p>            
 
<p>4.&nbsp;注册后您会收到华为商城的邮箱验证邮件，请通过邮件提供的网址及时完成邮箱安全验证；</p>
 <p style="text-align:center;"></p>
 
<p>5. &nbsp;请通过邮件提供的网址及时完成邮箱安全验证，验证成功后出现“恭喜您，激活帐号成功！”的提示语。到此，您便完成了华为商城电子邮箱注册。</p>

 <p style="text-align:center;"></p>


  <p><b>（二）手机号码注册</b>&nbsp;&nbsp;<a class="button-style-5" target="_blank" href="javascript:if(confirm('http://hwid1.vmall.com:8080/oauth2/portal/regbyphone.jsp?service=http%3A%2F%2Fwww.vmall.com%2Faccount%2Fcaslogin&loginChannel=26000000&reqClientType=26  \n\n�ļ���δ�� Teleport Pro ȡ�أ���Ϊ �������·��������ʼ��ַ�����õķ�Χ��  \n\n��Ҫ�ӷ������ϴ�����'))window.location='http://hwid1.vmall.com:8080/oauth2/portal/regbyphone.jsp?service=http%3A%2F%2Fwww.vmall.com%2Faccount%2Fcaslogin&loginChannel=26000000&reqClientType=26'" tppabs="http://hwid1.vmall.com:8080/oauth2/portal/regbyphone.jsp?service=http%3A%2F%2Fwww.vmall.com%2Faccount%2Fcaslogin&loginChannel=26000000&reqClientType=26"title="去注册"><span>去注册</span></a></p>

<p>1.&nbsp;打开华为商城网站（<a href="javascript:if(confirm('http://www.vmall.com/  \n\n�ļ���δ�� Teleport Pro ȡ�أ���Ϊ �������·��������ʼ��ַ�����õķ�Χ��  \n\n��Ҫ�ӷ������ϴ�����'))window.location='http://www.vmall.com/'" tppabs="http://www.vmall.com/" target="_blank" title="华为商城">www.vmall.com</a>），点击网页顶部“免费注册”，商城网页会自动进入注册页面；</p>
<p style="text-align:center;"></p>
 
<p>2.&nbsp;进入注册页面，点击“手机号码注册”；</p>
<p style="text-align:center;"></p>
 
<p>3.&nbsp;按照网页提示，填写您常用的手机号码，然后点击“获取手机验证码”，您注册的手机便会收到华为商城发送的验证码，请将收到的验证码填写在“手机验证码”旁边的方框中（如下图所示）；</p>
<p style="text-align:center;"></p>
 
<p>4.&nbsp;设置账号密码，输入验证码；选中“同意华为帐号注册协议”，点击“立即注册”（如下图所示）；到此，您便完成了华为商城手机号码注册。</p>
<p style="text-align:center;"></p>

</div>
            <div class="f">
            	<b></b>
                <s></s>
            </div>
        </div>
    </div>
	<div class="fl u-1-5">
    	
<!--左边菜单-20121024 -->
<div class="help-menu-area">
    <div class="b">
        <ul>
			<li><h3>购物指南</h3>
            	<ol>
                	
                    <li id="help_buy"><a href="{{ url('home/help/buy') }}"  title="如何购买"><span>如何购买</span></a></li>
                    <li id="help_buyContract"><a href="{{ url('home/help/buyContract') }}"  title="合约机"><span>合约机</span></a></li>
                </ol>
            </li>
        	<li><h3>账户管理</h3>
            	<ol>
                    <li id="help_regForget"><a href="{{ url('home/help/regForget') }}" title="找回密码"><span>找回密码</span></a></li>
                    <li id="help_regAgreement"><a href="{{ url('home/help/regAgreement') }}"  title="注册协议"><span>注册协议</span></a></li>
					<li id="help_index"><a href="{{ url('home/help/index') }}" tppabs="index" title="注册"><span>注册</span></a></li>
                </ol>
            </li>
            <li><h3>订单操作</h3>
            	<ol>
					<li id="help_orderDel"><a href="{{ url('home/help/orderDel') }}"  title="取消订单"><span>取消订单</span></a></li>
                	<li id="help_order"><a href="{{ url('home/help/order') }}"  title="查询订单"><span>查询订单</span></a></li>
                   
                </ol>
            </li>
            <li><h3>配送方式</h3>
            	<ol>
                	<li id="help_delivery"><a href="{{ url('home/help/delivery') }}" title="第三方快递"><span>第三方快递</span></a></li>
                    <li id="help_deliverySelect"><a href="{{ url('home/help/deliverySelect') }}"  title="查询物流"><span>查询物流</span></a></li>
                </ol>
            </li>
            <li><h3>支付方式</h3>
            	<ol>
                	<li id="help_payment"><a href="{{ url('home/help/payment') }}"  title="网银支付"><span>网银支付</span></a></li>
                    <li id="help_paymentHDFK"><a href="{{ url('home/help/paymentHDFK') }}"  title="货到付款"><span>货到付款</span></a></li>
                </ol>
            <li><h3>关于商城</h3>
            	<ol>
                	<li id="help_company"><a href="{{ url('home/help/company') }}"  title="公司介绍"><span>公司介绍</span></a></li>
                    <li id="help_bd"><a href="{{ url('home/help/bd') }}"  title="商务合作"><span>商务合作</span></a></li>
                </ol>
            </li>
        </ul>
    </div> 
</div><!--左边菜单-end -->
    </div>
</div>
<div class="hr-60"></div>
<!--口号-20121025 -->
@endsection
