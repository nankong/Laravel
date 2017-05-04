@extends('Home.base.header')
@section('bodycss')
<body>
@endsection
@section('body')
	<!-----------------折叠-导航条---------------------------->
	
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
		  	// console.log(responseText);
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
				<li  id="index"><a  href="{{ url('home/index') }}"  class="current"><span>首 页
						</span></a>
						</li>
			<li  id="nav-sale"><a  href="/home/search/荣耀6"  target="_blank"><span>荣耀6
				<s><img  src="{{ asset('Home/Images/new.png') }}"  alt="new"></s>
			</span></a> </li>
						
			<li  id="club"><a   href="/home/search/华为P7"  ><span>华为P7
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
	@yield('content')	
	<div class="fl u-1-5">
		</div>
	</div>
	<div class="hr-60"></div>
	<!----------------引入底部公共头---------------------------->
@endsection
