<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>付款成功_华为商城</title>
<link rel="shortcut icon" href="{{ asset('Home/Ico/favicon.ico') }}"/>
<link href="{{ asset('Home/Css/cart.ec.core.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('Home/Css/cart.main.css') }}" rel="stylesheet" type="text/css">
<script type="text/javascript" src="{{ asset('Home/Jquery/jquery-1.7.2.js') }}"></script>
<!--[if lt IE 9]> <![endif]-->
<style type="text/css">
    #order-confirm-detail #go_play{
       width:100px;
	   height:30px;
       line-height:30px;
	   text-align:center;
	   margin-top:100px;
	}
</style>
</head>
<body>
<!-- 捷径栏粉红条部分 -->
@include('Home.base.pinkheader')
<!--头部 -->
<div class="order-header">
	<div class="g">
    	<div class="fl">
            <div class="logo"><a href="/"><img src="{{ asset('Home/images/newLogo.png') }}" /></a></div>
        </div>
        <div class="fr">
            <div class="progress-area progress-area-2">
                <div id="progress-submit" class="progress-sso-area hide" style="display:block;">成功提交订单</div>
            </div>
        </div>
    </div>
</div>

<form action="" id="pay-go-form" method="post" target="_blank" class="hide">
	<input type="hidden" name="orderCode" value="1070054253">
	<input type="hidden" name="paymentMethod" id="order-paymentMethod" value="">	
	<input type="hidden" name="paymentType" id="order-paymentType" value="">
	<input type="hidden" name="state" value="1">
</form>
<div class="layout">
	<!-- 20131130-订单-确认-鼠标悬停增加ClassName： order-confirm-expand -->
    <div class="order-confirm" id="order-confirm-detail" style="height:300px">
		<div class="h" style="height:200px">
			<s class="icon-success-7"></s>
			<h3>{{ $msg }}</h3>			
			<p>订单号：&nbsp;&nbsp;{{ $id }}&nbsp;&nbsp;&nbsp;&nbsp;</p>
			<a  id="go_play" title="继续逛逛" href="{{ url('/') }}" class="button-style-4 button-walking">
			    继续逛逛&nbsp;&gt;&gt;
			</a>
		</div>
	<div class="hr-15"></div>
</div>
</div>

@include('Home.base.footer')

</body>
</html>
