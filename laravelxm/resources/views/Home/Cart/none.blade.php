<!DOCTYPE html>
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Language" content="zh-cn">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<meta name='csrf-token' content="{{ csrf_token() }}"> 
<title>购物车_华为商城</title>
<link rel="shortcut icon" href="{{ asset('Home/Ico/favicon.ico') }}">
<link href="{{ asset('Home/Css/cart.ec.core.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('Home/Css/cart.main.css') }}" rel="stylesheet" type="text/css">
<script type="text/javascript" src="{{ asset('Home/Jquery/jquery-1.7.2.js') }}"></script>
</head>
<body class="sc">
<!-- 20130605-qq-彩贝-start -->
<div class="qq-caibei-bar hide" id="caibeiMsg">
	<div class="layout">
		<div class="qq-caibei-bar-tips" id="HeadShow"></div>
		<div class="qq-caibei-bar-userInfo" id="ShowMsg"></div>
	</div>
</div>
<!-- 20130605-qq-彩贝-end -->
<!-- 捷径栏 -->
@include('Home.base.pinkheader')
<!--头部 -->
<div class="order-header">
	<div class="g">
    	<div class="fl">
            <div class="logo"><a href="/" title="华为商城"><img src="{{ asset('Home/images/newLogo.png') }}" alt="华为商城"></a></div>
        </div>
        <div class="fr">
            <!--步骤条-三步骤 -->
            <div class="progress-area progress-area-3">
                <!--我的购物车 -->
                <div style="display: block;" id="progress-cart" class="progress-sc-area hide">我的购物车</div>
                <!--核对订单 -->
                <div id="progress-confirm" class="progress-co-area hide">填写核对订单信息</div>
                <!--成功提交订单 -->
                <div id="progress-submit" class="progress-sso-area hide">成功提交订单</div>
            </div>
        </div>
    </div>
</div>
<div class="layout">
    <!-- 20131223-购物车-start -->
    <div class="sc-list">
    	<!-- 20131223-购物车-商品列表-start -->
    	<div class="sc-pro-list">

            <!-- 20131223-订单-商品-标题-start -->
            <div class="sc-pro-title-area">
                <div class="h">
                    <table border="0" cellpadding="0" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="tr-check">
                                	<input id="checkAll-top" class="vam" autocomplete="off" type="checkbox">
                                </th>
                                <th class="tr-pro">商品</th>
                                <th class="tr-price">单价<em>（元）</em></th>
                                <th class="tr-quantity">数量</th>
                                <th class="tr-subtotal">小计<em>（元）</em></th>
                                <th class="tr-operate">操作</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <!-- 20131223-订单-商品-标题-end -->
		</div>
		<!--购物车-商品列表 end -->

        <!--购物车-空数据 --> 
        <div id="cart-empty-msg" class="sc-empty-area">
            亲，您购物车里还没有物品哦，<a href="{{ url('/') }}">快去逛逛吧！</a>&nbsp;&nbsp;<span style="color:red"></span>秒后跳转..
        </div>
        <!-- 购物车列表 End-->
    </div>
<script type="text/javascript">
    $(function(){
	   var url="/";
	   var timer=6;
	   setInterval(function(){
	       timer--;
		   if(timer<=0){
		      window.location.href=url;
		   }
	      $("#cart-empty-msg").find('span').html(timer);
	   },1000);
	});
</script>
    <div class="hr-35"></div>
<!--商品删除记录-20121011 -->
    <div style="display: none;" id="pro-recover-area" class="pro-delete-area hide">
    	<div class="h clearfix">
        	<h3>已删除商品</h3>
			<table border="0" cellpadding="0" cellspacing="0">
				<tbody>
					<tr>
						<th class="tr-pro">商品</th>
						<th class="tr-quantity">数量</th>
						<th class="tr-subtotal">小计<em>（元）</em></th>
						<th class="tr-operate">操作</th>
					</tr>
				</tbody>
			</table>
        </div>
        <div class="b">
          <div class="pro-delete-item">
        	<table border="0" cellpadding="0" cellspacing="0">
            	<tbody id="pro-recover-tb"></tbody>
            </table>
          </div>
        </div>
        
        
        <div id="pro-delete-shop-start" class="f button-pro-delete-expand hide"><a href="javascript:;">更多已删除商品<i></i><s></s><b></b></a></div>
        <div id="pro-delete-shop-end" class="f button-pro-delete-shrink hide"><a href="javascript:;">收起已删除商品<i></i><s></s><b></b></a></div>
    </div>
<!--删除记录结束 -->
<div class="hr-25"></div>
<!--热门推荐-20121011 -->
    <div id="pro-recommend-area" class="pro-scroller-area hide">
	   	<div class="h">
        	<h3>您可能感兴趣的商品</h3>
        </div>
        <div class="b">
        	<!--左边滚动按钮className：pro-scroller-back 不可点击className：pro-scroller-back-disabled ；右边滚动按钮className：pro-scroller-forward 不可点击className：pro-scroller-forward-disabled --> 
             <a id="cart-img-prev" class="pro-scroller-back-disabled" href="javascript:;" onclick="ec.cart.slider.prev(this)"></a>
            <div class="pro-list">
            	<!--ul的宽度等于li宽度*N -->
                <ul style="width:1158px;" id="pro-recommend-list"></ul>
            </div>
            <a id="cart-img-next" class="pro-scroller-forward" href="javascript:;" onclick="ec.cart.slider.next(this)"></a>
        </div>
    </div>
<!--热门推荐结束 -->

    <!-- 购物车主体 End　-->
</div>
<div class="hr-75"></div>

<textarea id="product-list-html" class="hide"><!--#macro product-list
 data-->
<!--#var context=data.context-->
<!--#var mediaPath=data.mediaPath-->
<!--#list data.bundlerList as b-->
<div class="sc-pro-area selected" id="order-pro-{#b.bundleId}">
	<table border="0" cellpadding="0" cellspacing="0">
		<tbody>
			<!--#var rows=b.skuList.length-->
			<!--#var giftLen=0-->
			<!--#var lst_i=1-->
			<!--#list b.skuList as lst-->
				<!--#if (lst.giftList)-->
					<!--#var giftLen=giftLen+lst.giftList.length-->
				<!--/#if-->
			<!--/#list-->

			<!--#list b.skuList as lst-->			
			<tr class="sc-pro-item">
				<!--#if (lst_i==1)-->
				<td rowspan="{#rows+giftLen}" class="tr-check">
					<input id="box-{#b.bundleId}" class="checkbox" type="checkbox" 
name="bundleIds" onclick="ec.shoppingCart.check(this);" 
value="{#b.bundleId}" checked />
				</td>
				<!--/#if-->
				
				<td class="tr-pro">
				<div class="pro-area clearfix" id="skuId-{#lst.skuId}">
					<p class="p-img">
					<!--#var skuId='#'+lst.skuId;-->
					<a title="{#lst.prdSkuName?html}" target="_blank" 
href="{#context}/product/{#lst.id}.html{#skuId}" 
seed="cart-item-name">
						<img alt="{#lst.prdSkuName?html}" 
src="{#mediaPath}{#lst.photoPath}78_78_{#lst.photoName}" />
					</a>
					</p>
					<p class="p-name">
						<b>[套餐]</b>
						<a title="{#lst.prdSkuName?html}" target="_blank" 
href="{#context}/product/{#lst.id}.html{#skuId}" 
seed="cart-item-name">{#lst.prdSkuName?html}</a>
					</p>
					<p class="p-sku">
						<em class="p-spite-sku">{#lst.skuAttrValues?html}</em>
					</p>
					<!--#if (lst.shopName &amp;&amp; lst.shopId != 1)-->
					<p class="p-explain">此商品由{#lst.shopName?html}发货</p>
					<!--/#if-->
					<p class="limitstock-{#lst.skuId} hide"></p>
					<p class="understock-{#lst.skuId} hide"></p>
					<input type="checkbox" name="skuIds" class="hide" 
value="{#lst.skuId}">
				</div>
				</td>

				<td class="tr-price">
					<s>原价:¥{#lst.skuPrice.toFixed(2)}</s>
					<span>现价:¥{#lst.preferentialPrice.toFixed(2)}</span>
				</td>

				<!--#if (lst_i==1)-->
				<td class="tr-quantity" rowspan="{#rows+giftLen}">
				<div class="sc-stock-area">
					<div class="stock-area">
						<input id="quantity-{#b.bundleId}" type="text" 
class="shop-quantity textbox vam" value="{#b.quantity}" 
data-skuId="{#b.bundleId}" data-type="2" seed="cart-item-num" />
					</div>
				</div>
				</td>
				
				<td rowspan="{#rows+giftLen}" class="tr-subtotal">
				    <b>¥{#b.totalBundlePrice.toFixed(2)}</b>
				  	
<span><i>省</i><em>
¥{#b.preferentialPrice.toFixed(2)}</em></span>
				</td>
				
				<td rowspan="{#rows+giftLen}" class="tr-operate">
					<a href="javascript:;" class="icon-sc-del" title="删除" 
onclick="ec.shoppingCart.del(this , {#b.bundleId}, 2)" 
seed="cart-item-del">删除</a>
				</td>
				<!--/#if-->
			</tr>
			<!--#var lst_i=lst_i+1-->
			<!--/#list-->

			<!--#list b.skuList as lst-->
			<!--#if (giftLen > 0)--> 
			<!--#list lst.giftList as gif-->
				<!--#var skuId='#'+gif.skuId;-->
				<tr class="sc-pro-gift-item">
				  <td class="tr-pro">
					<div class="pro-area clearfix">
						<p class="p-img">
							<a title="{#gif.prdSkuName}" 
href="{#context}/product/{#gif.id}.html{#skuId}">
								<img alt="{#gif.prdSkuName}" 
src="{#mediaPath}{#gif.photoPath}78_78_{#gif.photoName}" />
							</a>
							<input type="checkbox" name="skuIds" class="hide" 
value="{#gif.skuId}">
						</p>
						<p class="p-name">
							<b>[赠品]</b>
							<a title="{#gif.prdSkuName}" 
href="{#context}/product/{#gif.id}.html{#skuId}">{#gif.prdSkuName}</a>

						</p>
						<p class="understock-{#gif.skuId} hide"></p>
					</div>
				</td>
				<td class="tr-price">
					<s>原价:{#gif.skuPrice.toFixed(2)}</s>
					<span>现价:¥0.00</span>
				</td>
				</tr>
			<!--/#list-->
			<!--/#if-->
			<!--/#list-->
		</tbody>
	</table>
</div>
<!--/#list-->

<!--#list data.productList as lst-->
<!--#var skuId = "#" + lst.skuId; -->
<div class="sc-pro-area selected" id="order-pro-{#lst.skuId}">
	<table border="0" cellpadding="0" cellspacing="0">
		<tbody>
			<tr class="sc-pro-item">
				<td rowspan="{#lst.giftList.length+lst.extendList.length + 
lst.accidentList.length + 1}" class="tr-check">
					<input id="box-{#lst.skuId}" class="checkbox" type="checkbox" 
name="skuIds" onclick="ec.shoppingCart.check(this);" 
value="{#lst.skuId}" checked />
				</td>
				<td class="tr-pro">
				<div class="pro-area clearfix">
					<p class="p-img">
						<a title="{#lst.prdSkuName?html}" target="_blank" 
href="{#context}/product/{#lst.id}.html{#skuId}" 
seed="cart-item-name">
							<img alt="{#lst.prdSkuName?html}" 
src="{#mediaPath}{#lst.photoPath}78_78_{#lst.photoName}" />
						</a>
					</p>
					<p class="p-name">
						<a title="{#lst.prdSkuName?html}" target="_blank" 
href="{#context}/product/{#lst.id}.html{#skuId}" 
seed="cart-item-name">{#lst.prdSkuName?html}</a>
					</p>
					<p class="p-sku">
						<em class="p-spite-sku">{#lst.skuAttrValues?html}</em>
					</p>
					<!--#if (lst.shopName &amp;&amp; lst.shopId != 1)-->
					<p class="p-explain">此商品由{#lst.shopName?html}发货</p>
					<!--/#if-->
					<p class="understock-{#lst.skuId} hide"></p>
				</div>
				</td>
				<td class="tr-price">
					<!--#if (lst.skuPrice != lst.preferentialPrice)-->
						<s>原价:¥{#lst.skuPrice.toFixed(2)}</s>
						<span>现价:¥{#lst.preferentialPrice.toFixed(2)}</span>
					<!--#else-->
						<span>¥{#lst.skuPrice.toFixed(2)}</span>
					<!--/#if-->
				</td>
				<td class="tr-quantity" 
rowspan="{#lst.giftList.length+lst.extendList.length + 
lst.accidentList.length + 1}">
                	<div class="sc-stock-area">
						<div class="stock-area">
							<input id="quantity-{#lst.skuId}" type="text" 
class="shop-quantity textbox vam" value="{#lst.quantity}" 
data-skuId="{#lst.skuId}" data-type="{#lst.productType}" 
seed="cart-item-num" />
						</div>
						<p class="normalLimitstock-{#lst.skuId} hide"></p>
					</div>
				</td>
				
				<td rowspan="{#lst.giftList.length + 1}" class="tr-subtotal">
					<b>¥{#(lst.preferentialPrice * 
lst.quantity).toFixed(2)}</b>
					<!--#if (lst.skuPrice != lst.preferentialPrice)-->
						<span><i>省</i><em>¥ {#((lst.skuPrice - 
lst.preferentialPrice) * 
lst.quantity).toFixed(2)}</em></span>
					<!--/#if-->		
				</td>
				<td rowspan="{#lst.giftList.length + 1}" class="tr-operate">
					<a href="javascript:;" class="icon-sc-del" title="删除" 
onclick="ec.shoppingCart.del(this , {#lst.skuId})" 
seed="cart-item-del">删除</a>
				</td>
			</tr>
			<!--#list lst.giftList as gif-->
			<!--#var skuId='#'+gif.skuId;-->
			<tr class="sc-pro-gift-item">
				<td class="tr-pro">
					<div class="pro-area clearfix">
						<p class="p-img">
							<a title="{#gif.prdSkuName}" 
href="{#context}/product/{#gif.id}.html{#skuId}">
								<img alt="{#gif.prdSkuName}" 
src="{#mediaPath}{#gif.photoPath}78_78_{#gif.photoName}" />
							</a>
							<input type="checkbox" name="skuIds" class="hide" 
value="{#gif.skuId}">
						</p>
						<p class="p-name">
							<b>[赠品]</b>
							<a title="{#gif.prdSkuName}" 
href="{#context}/product/{#gif.id}.html{#skuId}">{#gif.prdSkuName}</a>

						</p>
						<p class="understock-{#gif.skuId} hide"></p>
					</div>
				</td>
				<!--td class="tr-span-3">{#lst.quantity * gif.quantity}<p 
class="limitstock-{#gif.skuId} hide"></p></td-->
				<td class="tr-price">
					<s>原价:¥{#gif.skuPrice.toFixed(2)}</s>
					<span>现价:¥0.00</span>
				</td>
			</tr>
			<!--/#list-->
			<!--#if (lst.extendList)-->
			<!--#list lst.extendList as yb-->
			<!--#var ybSkuId='#'+yb.skuId;-->
			<tr class="sc-pro-gift-item">
				<td class="tr-pro">
					<div class="pro-area clearfix">
						<p class="p-img">
							<a title="{#yb.prdSkuName}" target="_blank" 
href="{#context}/product/{#yb.id}.html{#ybSkuId}">
								<img alt="{#yb.prdSkuName}" 
src="{#mediaPath}{#yb.photoPath}78_78_{#yb.photoName}" />
							</a>
						</p>
						<p class="p-name">
							<b>[延保]</b>
							<a title="{#yb.prdSkuName}" target="_blank" 
href="{#context}/product/{#yb.id}.html{#ybSkuId}">{#yb.prdSkuName}</a>

						</p>
						<p class="p-sku"><em></em></p>
						<input type="checkbox" name="extendIds" class="hide" 
value="{#yb.skuId}">
					</div>
				</td>
				<!--td class="tr-span-3">{#yb.quantity}</td-->
				<td class="tr-price">
					<s>原价:¥{#yb.skuPrice.toFixed(2)}</s>
					<span>现价:¥{#yb.skuPrice.toFixed(2)}</span>
				</td>
				<td class="tr-subtotal"><b>¥{#(yb.skuPrice * 
lst.quantity).toFixed(2)}</b></td>
				<td class="tr-operate">
					<a href="javascript:;" class="icon-sc-del" title="删除" 
onclick="ec.shoppingCart.del(this, {#yb.skuId}, 6, {#yb.mainSkuId})" 
seed="cart-item-del">删除</a>
				</td>
			</tr>
			<!--/#list-->
			<!--/#if-->
			<!--#if (lst.accidentList)-->
			<!--#list lst.accidentList as ya-->
			<!--#var yaSkuId='#'+ya.skuId;-->
			<tr class="sc-pro-gift-item">
				<td class="tr-pro">
					<div class="pro-area clearfix">
						<p class="p-img">
							<a title="{#ya.prdSkuName}" target="_blank" 
href="{#context}/product/{#ya.id}.html{#yaSkuId}">
								<img alt="{#ya.prdSkuName}" 
src="{#mediaPath}{#ya.photoPath}78_78_{#ya.photoName}" />
							</a>
						</p>
						<p class="p-name">
							<b>[意外保]</b>
							<a title="{#ya.prdSkuName}" target="_blank" 
href="{#context}/product/{#ya.id}.html{#yaSkuId}">{#ya.prdSkuName}</a>

						</p>
						<p class="p-sku"><em></em></p>
						<input type="checkbox" name="accidentIds" class="hide" 
value="{#ya.skuId}">
					</div>
				</td>
				<!--td class="tr-span-3">{#ya.quantity}</td-->
				<td class="tr-price">
					<s>原价:¥{#ya.skuPrice.toFixed(2)}</s>
					<span>现价:¥{#ya.skuPrice.toFixed(2)}</span>
				</td>
				<td class="tr-subtotal"><b>¥{#(ya.skuPrice * 
lst.quantity).toFixed(2)}</b></td>
				<td class="tr-operate">
					<a href="javascript:;" class="icon-sc-del" title="删除" 
onclick="ec.shoppingCart.del(this, {#ya.skuId}, 7, {#ya.mainSkuId})" 
seed="cart-item-del">删除</a>
				</td>
			</tr>
			<!--/#list-->
			<!--/#if-->
		</tbody>
	</table>
</div>
<!--/#list-->
<!--/#macro-->
</textarea>

@include('Home.base.footer')