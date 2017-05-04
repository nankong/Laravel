<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>确认订单_华为商城</title>
<link rel="shortcut icon" href="{{ asset('Home/Ico/favicon.ico') }}" />
<link href="{{ asset('Home/Css/cart.ec.core.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('Home/Css/cart.main.css') }}" rel="stylesheet" type="text/css">
<script type="text/javascript" src="{{ asset('Home/Jquery/jquery-1.7.2.js') }}"></script>


<style type="text/css">
  #select_express{
      width:148px;
	  height:23px;
	  border-color:rgb(204,204,204);
	  color:#727272;
  }

</style>
</head>
<body>
<!-- 捷径栏 -->
@include('Home.base.pinkheader')
<!--头部 -->
<div class="order-header">
	<div class="g">
    	<div class="fl">
            <div class="logo"><a href=""><img src="{{ asset('Home/images/newLogo.png') }}" /></a></div>
        </div>
        <div class="fr">
            <!--步骤条-三步骤 -->
            <div class="progress-area progress-area-3">
                <!--我的购物车 -->
                <div id="progress-cart" class="progress-sc-area hide">我的购物车</div>
                <!--核对订单 -->
                <div id="progress-confirm" class="progress-co-area hide" style="display:block;">填写核对订单信息</div>
                <!--成功提交订单 -->
                <div id="progress-submit" class="progress-sso-area hide">成功提交订单</div>
            </div>
        </div>
    </div>
</div>
<div class="layout">
    <div class="order-confirm" id="order-confirm-detail">
        <div class="h">
            <s class="icon-success-7"></s>
            <h3>订单提交成功，请您尽快付款！</h3>         
            <p>订单号：&nbsp;&nbsp;{{ $id }}&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;待付款金额：&nbsp;&nbsp;<b>{{ $car_end_money }}</b>&nbsp;<b>元</b></p>
            <div class="tips">请您尽快完成支付。</div>
        </div>
        <div class="b">
            <table>
                <tbody>
                    <tr>
                        <th>订单金额：</th>
                        <td>{{ $car_end_money }}元</td>
                    </tr>
                    <tr>
                        <th>下单时间：</th>
                        <td>{{ date('Y-m-d H:i:s',$id) }}</td>
                    </tr>
                    <tr>
                        <th>配送方式：</th>
                        <td>
                            顺丰快递&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            运费￥{{ $yunfei }}                     
                        </td>
                    </tr>
                
                    <tr>
                        <th>订单编号：</th>
                        <td>{{ $id }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="f"><a href="javascript:;" onclick="$('#order-confirm-detail').toggleClass('order-confirm-expand')">订单详情<i></i><s></s><b></b></a></div>
    </div>
</div>
<div class="g order"> 
    <!--栏目 -->
    <!--订单-表单 -->
    <div class="order-form-area">
		<!--订单-表单-地址-20121012 -->
    	<div class="order-address" id="order-address-mod">
            <h3 class="title">收货人信息</h3>
            <!--地址信息-20121012 -->
		
           	<div  class="order-address-detail-area hide"  id="address-default-info"  style="display: block;">
				<div  class="form-detail-area">
				  
				 <table  cellspacing="0"  cellpadding="0"  border="0"><tbody>
					 <tr></php>
						 <th>收&nbsp;&nbsp;货&nbsp;&nbsp;人：</th><td>{{ $add->address_consignee }}</td>
					</tr>
					 <tr>
						 <th>收货地址：</th><td>{{ $add->address_province.' '.$add->address_city.' '.$add->address_county.' '.$add->address_detail }}</td>
					</tr>
					<tr>
						 <th>手机号码：</th>
						 <td>{{ $add->address_consignee_phone }}</td>
					</tr>
					</tbody>
					</table>
					<p>
					<a href="/home/address" class="icon-edit fcn" title="选择其他收货地址" id="select_other_address">
					选择其他收货地址&nbsp;</a>				
				</div>
		    </div>
        </div>
        <div class="order-delivery">
        	<h3 class="title">配送方式</h3>
            <div class="order-form-tips" id="order-delivery-tips"><p>顺丰快递</p></div>
            <ul class="order-delivery-list" id="order-delivery-list">
            </ul>
        </div>
        <div class="order-coupon">
    <!--订单详情-->
	<h3 class="title">商品清单 <em></em></h3>
    <div class="sc-area">
        <div class="order-pro-list" id="order-pro-list">
			<!--订单-商品-标题 -->
            <div class="order-pro-title-area">
                <div class="b">
                    <table border="0" cellpadding="0" cellspacing="0">
                        <thead>
                            <tr>
                                <th>商品</th>
                                <th class="tr-span-3">单价<em>/元</em></th>
                                <th class="tr-span-3">数量</th>
                                <th class="tr-span-4">小计<em>/元</em></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
			<!--订单-商品-套餐-->	
		@foreach($list as $v)
			<!--遍历页-->
			<volist name="new_car" id="vo">
			<div class="order-pro-area">
				<table border="0" cellpadding="0" cellspacing="0">
					<tbody>
						
						<tr>
							<td class="tal">
								<ul class="pro-area-2">
									<li><a href="home/goodinfo/{{ $v->order_goodsid }}"><img src="{{ asset('Admin/upload') }}/{{ $v->order_goodspic }}" width="50" height="50">{{ $v->order_goodsnam }}</a></li>
								</ul>
							</td>							
							<td class="tr-span-3">&yen;{{ $v->order_price }}</td>
							<td class="tr-span-3">{{ $v->order_goodsnum }}</td>
							<td rowspan="4" class="tr-span-4"><p class="bold">&yen;{{ $v->order_pricesum }}</p></td>
						</tr>

					</tbody>
				</table>
				
			</div>
			</volist>
		   <!--遍历页-->
        @endforeach
        </div>     
       
        <!--总计 -->
        <div class="total-area clearfix">
            <div class="total-line-2"></div>
             <!--订单-费用-->
            <div class="order-cost-area">
                <table border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <td class="tal"></td>
                            <td class="tar">商品金额总计：&yen;<em id="order-cost-area" data-oldval=" 1299.00">{{ $car_total_money }}</em></td>
                        </tr>
                        <tr>
                            <td class="tal"></td>
                            <td class="tar">
                            	运费：<em id="order-deliveryCharge">&yen; <span>{{ $yunfei }}<span></em>
                            </td>
                        </tr>
                        <tr>
                            <td class="tal">
                               
                            </td>
                            <td class="tar">
                            	优惠金额：<em>- &yen; 
                                <span id="order-discountTotalPrice" data-oldVal="0.00">{{ $car_sale_money }}</span></em>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="total-left-area clearfix">

                <div class="fl order-sp-area">
                </div>    
               
                <div class="fr">
                    <em>包裹合计（含运费）</em>
                    <b>&yen;</b> <b id="order-price" class="total" data-oldval="1299.00">{{ $car_end_money }}</b>
                </div>
            </div>
        </div>
        <div class="hr-30"></div>
        <div class="order-action-area tar">
            <a href="{{ url('/home/cart/submit') }}/{{ $id }}" class="button-style-1 button-submit-order " title="去支付" seed="checkout-submit"><span>去支付</span></a>
        </div>
    </div>
</div>
<div class="hr-60"></div>

@include('Home.base.footer')
</body>
</html>