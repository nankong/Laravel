@extends('Home.base.header')
@section('title')
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>没有搜索到商品页</title>
<meta name="keywords" content="华为">
<link href="{{ asset('Home/Css/ec.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('Home/Css/main.css') }}" rel="stylesheet" type="text/css">
<script src="{{ asset('Home/Js/jsapi.js') }}" namespace="ec"></script><!--[if lte IE 6]><script>ol.isIE6=true;</script><![endif]--><!--[if IE 7]><script>ol.isIE7=true;</script><![endif]--><!--[if IE 8]><script>ol.isIE8=true;</script><![endif]-->
<script src="{{ asset('Home/Js/jquery-1.js') }}"></script>
<script src="{{ asset('Home/Js/ec_002.js') }}"></script> 
<script src="{{ asset('Home/Js/ec.js') }}"></script> 
@endsection
@section('bodycss')
@endsection
@section('body')
<div  class="naver-main">
		<div  class="layout">   
			<div  class="category"  id="category-block">    
				<div  class="h"  id="category-h">
					<h2>全部商品</h2>
					<i  class="icon-category"  id="category-icon"></i>
				</div>
				<div  class="b"  id="category-list">
					<ul>
						 <!--  <li>
								<h3><a  href="http://www.vmall.com/list-1"><span>手机</span></a></h3>
									<a  href="http://www.vmall.com/list-1#2"><span>手机</span></a>
									<a  href="http://www.vmall.com/list-1#5"><span>配件</span></a>
							</li>
							<li  class="odd">
								<h3><a  href="http://www.vmall.com/list-27"><span>运营商</span></a></h3>
									<a  href="http://www.vmall.com/list-27#29"><span>购机送费</span></a>
									<a  href="http://www.vmall.com/list-27#28"><span>选号入网</span></a>
									<a  href="http://www.vmall.com/list-27#33"><span>上网卡</span></a>
							</li>
							<li>
								<h3><a  href="http://www.vmall.com/list-9"><span>平板电脑</span></a></h3>
									<a  href="http://www.vmall.com/list-9#10"><span>平板电脑</span></a>
									<a  href="http://www.vmall.com/list-9#11"><span>配件</span></a>
							</li>
							<li  class="odd">
								<h3><a  href="http://www.vmall.com/list-6"><span>宽带网络</span></a></h3>
									<a  href="http://www.vmall.com/list-6#7"><span>移动网络</span></a>
									<a  href="http://www.vmall.com/list-6#8"><span>家庭网络</span></a>
							</li>
							<li>
								<h3><a  href="http://www.vmall.com/list-12"><span>增值服务</span></a></h3>
									<a  href="http://www.vmall.com/list-12#30"><span>华为秘盒</span></a>
									<a  href="http://www.vmall.com/list-12#35"><span>服务</span></a>
									<a  href="http://www.vmall.com/list-12#14"><span>配件</span></a>
							</li>
						<li  class="odd">
							<h3><a  href="http://app.vmall.com/"  target="_blank"><span>应用市场</span></a></h3>
							<a  href="http://app.vmall.com/game/list"  target="_blank"><span>手机游戏</span></a>
							<a  href="http://app.vmall.com/"  target="_blank"><span>手机应用</span></a>
						</li> -->
					</ul>
				</div>
			</div>
	<script type="text/javascript">
	   $(function(){
       $.ajax({
	      url:"/home/category",
		  type:'GET',
		  dataType:'json',
		  success:function(responseText,status,xhr){
		  	console.log(responseText);
		     if(status=='success'){
			     $("#category-list").find('ul').html(responseText);
				 $("#category-list ul li:odd").addClass('odd');
			 }else{
			     window.location.reload();
			 } 
		  }
	   });  
   });
	</script>   
			 <!-------------导航条---------------->
			<nav  class="naver">
					<ul  id="naver-list">
				<li  id="index"><a  href="{{ url('/') }}"  class="current"><span>首 页
						</span></a>
						</li>
			<li  id="nav-sale"><a  href="{:U('Product/index',array('g'=>2))}"  target="_blank"><span>荣耀6
				<s><img  src="{{ asset('Home/Images/new.png') }}"  alt="new"></s>
			</span></a> </li>
						
			<li  id="club"><a   href="{:U('Product/index',array('g'=>1))}"  ><span>华为P7
						</span></a> </li>
			<li  class=""><a  href="javascript:return false;"><span>精彩频道</span></a>
				
			</li>
	</ul>
			</nav><!-- 20130909-导航-end -->
		</div>
	</div>
	<!-------------导航条---------------->
	<script>
		
		$(function () {
			$('#naver-list li').hover(function () {
				$(this).addClass('hover');
			},function () {
				$(this).removeClass('hover');
			});
		});
				
	</script>           
			</nav>
		</div>
	</div>
	<script>
	(function () {
		//所有分类显示隐藏控制
		var isIndex =  false,
			categoryBlock = gid('category-block');
			
		if(isIndex) return;

		categoryBlock.onmouseover = function () {
			categoryBlock.className = 'category category-hove';
		};
		categoryBlock.onmouseout = function () {
			categoryBlock.className = 'category';
		};
		
	}());
	$(function () {
		//分类间隔背景色
		$('#category-list li:odd').addClass('odd');
		$('#category-list li a').click(function () {
			setTimeout(function () {
				var id = location.hash.split("#", 2)[1];
				if(id)return ec.product.showCategory(gid('pro-cate-'+ id) , id);
			}, 200);
			
		});
	});
	</script>
	<script>
	(function(){
		var n = $("#nav-1");
		n.children("a").addClass("current");
		n.siblings().children("a").removeClass("current");
	})();
	</script>
<div class="hr-5"></div>
<div class="g">
	<!--搜索-结果数 -->
	<div class="search-count-area"><h1 class="icon-search">搜索<b>{{ $keywords }}</b>共找到商品<em>0</em>件</h1></div>
</div>
<div class="hr-10"></div>
<div class="g search">
    <!--<div class="u-3-4">-->
        <!--搜索 -->
        <div id="ct-list" class="g-l-none search-area">
            <div class="h">
                <!--排序 -升序className：sort-asc  -降序className：sort-desc -没有则不添加className -->
                <div class="sort-area clearfix">
                    <ul>
                    	<li><b>商品排序：</b></li>
                        <li id="sort-sale" onclick="ec.search.sort('sale_number')" class="sort-desc"><a href="javascript:;" class="sort-sale">销量<s></s></a></li>
                        <li id="sort-price"><a href="javascript:;" class="sort-price" onclick="ec.search.sort('price')">价格<s></s></a></li>
                        <li id="sort-register_date"><a href="javascript:;" class="sort-added" onclick="ec.search.sort('register_date')">上架时间<s></s></a></li>
                    </ul>
                </div>
            </div>
            <div class="b"> 
        		<div class="search-empty-area">抱歉，没有找到您搜索的相关商品，试试修改搜索词吧！<span style="color:red;"></span>秒后跳转去首页</div> 
            	<div class="hr-25"></div>
            </div>
        </div>
</div>
<script type="text/javascript">
    $(function(){
	     var empty=$(".search-empty-area").find('span');
		 var url="/";
		 var i=8;
		 go();
		 setInterval(go,1000);
		 function go(){
		     i--; 
			 empty.html(i);
			 if(i<=0){
			    window.location.href=url;
			 }
		 
		 }
	});
</script>
<div class="hr-40"></div>
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
@endsection