@extends('Home.base.header')
@section('title')
<meta http-equiv="Content-Language" content="zh-cn">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>荣耀6_商品搜索_华为商城</title>
<meta name="keywords" content="">
<link href="{{ asset('Home/Css/ec.css') }}" rel="stylesheet" type="text/css">

<link href="{{ asset('Home/Css/main.css') }}" rel="stylesheet" type="text/css">
<!--[if lte IE 6]><script>ol.isIE6=true;</script><![endif]--><!--[if IE 7]><script>ol.isIE7=true;</script><![endif]--><!--[if IE 8]><script>ol.isIE8=true;</script><![endif]-->

<!--[if lt IE 9]><script src="{{ asset('Home/Js/html5shiv.js') }}"></script> <![endif]-->
<style>
#search-pager .current{
	border:1px solid #ccc;
	display:inline-block;
	width:7px;
	height:16px;
	font-weight:400;
	text-align:center;
	line-height:16px;
    font-size:12px;
	padding:0 5px;
	background:#D2D2D2;
	margin-left:5px;
	margin-right:5px;
}
#search-pager .num{
    border:1px solid #ccc;
	display:inline-block;
	width:7px;
	height:16px;
	font-weight:400;
	text-align:center;
	line-height:16px;
    font-size:12px;
	padding:0 5px;
	
	margin-left:5px;
	margin-right:5px;

}
#search-pager .prev{
    border:1px solid #ccc;
	display:inline-block;
	width:7px;
	height:16px;
	font-weight:400;
	text-align:center;
	line-height:16px;
    font-size:9px;
	padding-left:3px;
	padding-right:5px;
	
	margin-left:5px;
	margin-right:5px;
}

#search-pager .next{
    border:1px solid #ccc;
	display:inline-block;
	width:7px;
	height:16px;
	text-align:center;
	line-height:16px;
    font-size:9px;
	padding-left:3px;
	padding-right:5px;
	
	margin-left:5px;
	margin-right:5px;


}
</style>
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
	<div class="search-count-area"><h1 class="icon-search">搜索<b>{{ $keywords }}</b>共找到商品<em>{{ $goods_count }}</em>件</h1></div>
</div>
<div class="hr-10"></div>
<div class="g search">
        <!--搜索 -->
        <div id="ct-list" class="g-l-none search-area">
            <div class="h">
                <!--排序 -升序className：sort-asc  -降序className：sort-desc -没有则不添加className -->
                <div class="sort-area clearfix">
                    <ul>
                    	<li><b>商品排序：</b></li>
                        <li id="sort-price"><a href="{{ url('/home/search')}}/{{ $keywords }}/order?ob=price" class="sort-price">价格<s></s></a></li>
                        <li id="sort-register_date"><a href="{{ url('/home/search')}}/{{ $keywords }}/order?ob=time" class="sort-added" >上架时间<s></s></a></li>
                    </ul>
                </div>
            </div>
            <div class="b">
                <!--商品列表  -->
                <div class="pro-list">
                    <ul id="pro-list">
				<volist name="list_goods" id="vo">
				@foreach($search_info as $v)
					<li>
						<div>
						<p class="p-img"><a href="{{url('/home/goodinfo')}}/{{ $v->goods_id }}" title="{{ $v->goods_keywords }}" target="_blank"><img src="{{ asset('Admin/upload')}}/{{ $v->goods_big_pic }}" alt="{{ $v->goods_name }}"></a></p>
						<p class="p-price"><b>¥{{ $v->goods_sale_price }}</b></p>
						<p class="p-name"><a href="{{url('/home/goodinfo')}}/{{ $v->goods_id }}" title="{{ $v->goods_name }}" target="_blank"><span class="red">{{ $v->goods_name }}</span></a></p>
						 @if($v->goods_state == 'hot')
				            <i  class="p-tag"><img  src="{{ asset('Home/Images/1382542488099.png')  }}"  style=""></i>
				         @elseif($v->goods_state == 'new')
					         <i class="p-tag"><img  src="{{ asset('Home/Images/1382542518162.png')  }}"  style=""></i>
				         @elseif($v->goods_state == 'max')
				           <i class="p-tag"><img  src="{{ asset('Home/Images/1382542555129.png')  }}"  style=""></i>
				         @elseif($v->goods_state == 'first')
				             <i class="p-tag"><img  src="{{ asset('Home/Images/1382593860805.png')  }}"  style=""></i>  
					            <i class="p-tag"></i>
				         @endif
						 
						</div>
					</li>
				@endforeach
				 </volist>
                    </ul>
                </div>
            	<div class="hr-25"></div>
            	{{ $search_info->appends($where)->links() }}
                <!--分页 -->
            </div>
        </div>
</div>
<div class="hr-40"></div>
<script src="{{ asset('Home/Js/search.js') }}"></script><script id="jsapi_loader0" loadtype="insert" type="text/javascript" src="{{ asset('Home/Js/pager-min.js') }}" charset="gbk"></script><script>(function(){var time = 0,el = document.getElementById('jsapi_loader0');if(!el || (el.readyState && 'complete' != el.readyState)){ if(time<10){ setTimeout(arguments.callee,30); time++; }else{ logger.error('load the script of id jsapi_loader0 fail!');} return; }ol._setLoadStatus("ec.pager/pager-min.js","complete");})();</script>
@endsection