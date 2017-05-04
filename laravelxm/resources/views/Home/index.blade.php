@extends('Home.base.header')
@section('bodycss')
<body class="wide" style="background:#fff">
@endsection
@section('title')
<title>华为商城官网 -提供华为手机(华为荣耀6、华为Mate7、荣耀3C、荣耀畅玩版、华为P7、荣耀3X等)、平板电脑等产品的预约和购买</title>
<link href="{{ asset('Home/Css/ec.core.css')  }}"rel="stylesheet" type="text/css">
<link href="{{ asset('Home/Css/index.css')  }}"rel="stylesheet" type="text/css">
<link href="{{ asset('Home/Css/ad.css')  }}"rel="stylesheet" type="text/css">
<link href="{{ asset('Home/Css/aad.css')  }}"rel="stylesheet" type="text/css">
<script src="{{ asset('Home/Js/jsapi.js')  }}" namespace="ec"></script>
<script src="{{ asset('Home/Js/jquery-1.4.4.min.js')  }}"></script>
<script src="{{ asset('Home/Js/ec.core.js')  }}"></script>
<script src="{{ asset('Home/Js/ec.business.js')  }}"></script> 
<script src="{{ asset('Home/Js/html5shiv.js')  }}"></script>
<script type="text/javascript" src="{{ asset('Home/Js/jquery.min.js')  }}"></script>
<script src="{{ asset('Home/Jquery/jquery-1.7.2.js') }}"></script>
<style type="text/css">
   #searchBar-area  #search_kw{
      height:30px;
   }
</style>
@endsection
@section('body')
<!-- 导航 -->
<div class="naver-main">
	<div class="layout">
		<!-- 20130909-分类-start -->
		<div class="category category-index" id="category-block">
			<!-- 20130909-分类-start -->
			<div class="h" id="category-h">
				<h2>全部商品</h2>
				<i class="icon-category" id="category-icon"></i>
			</div>
			<div class="b" id="category-list">
				<ul>
					<!-- <li>
						<h3><a href="#"><span>手机</span></a></h3>
							<a href="#"><span>手机</span></a>
							<a href="#"><span>配件</span></a>
					</li>
					<li class="odd">
						<h3><a href="#"><span>运营商</span></a></h3>
						<a href="#"><span>购机送费</span></a>
						<a href="#"><span>选号入网</span></a>
						<a href="#"><span>上网卡</span></a>
					</li>
					<li>
						<h3><a href="#"><span>平板电脑</span></a></h3>
						<a href="#"><span>平板电脑</span></a>
						<a href="#"><span>配件</span></a>
					</li>
					<li class="odd">
						<h3><a href="#" target="_blank"><span>应用市场</span></a></h3>
						<a href="#" target="_blank"><span>手机游戏</span></a>
						<a href="#" target="_blank"><span>手机应用</span></a>
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
		<!-- 20130909-分类-end -->
		<!-- 20130909-导航-start -->
		<nav class="naver">
			<ul id="naver-list">
				<li id="index">
					<a href="#" class="current">
						<span>首 页</span>
					</a>
				</li>
				<li id="nav-sale">
					<a href="" target="_blank">
					<span>荣耀6<s><img src="{{ asset('Home/Images/new.png')  }}" alt="new"></s></span></a>
				</li>				
				<li id="club">
					<a href="" target="_blank">
					<span>华为P7</span></a>
				</li>
				<li>
					<a href="javascript:return false;"><span>精彩频道</span><i></i></a>					
				</li>
			</ul>
		</nav><!-- 20130909-导航-end -->
	</div>
</div>
<!-- 20130904-热门板-start -->
<div class="hot-board">
	<script type="text/javascript">
$(function() {
	var sWidth = $("#focus").width(); //获取焦点图的宽度（显示面积）
	var len = $("#focus ul li").length; //获取焦点图个数
	var index = 0;
	var picTimer;
	//以下代码添加数字按钮和按钮后的半透明条，还有上一页、下一页两个按钮
	 var btn = "<div class='btnBg'></div><div class='btn'>";
 	for(var i=0; i < len; i++) {
 		btn += "<span></span>";
 	}
	 btn += "</div><div class='preNext pre'></div><div class='preNext next'></div>";
 	$("#focus").append(btn);
	 $("#focus .btnBg").css("opacity",0.5);
	//为小按钮添加鼠标滑入事件，以显示相应的内容
	$("#focus .btn span").css("opacity",0.4).mouseenter(function() {
		index = $("#focus .btn span").index(this);
		showPics(index);
	}).eq(0).trigger("mouseenter");

	//上一页、下一页按钮透明度处理
	 $("#focus .preNext").css("opacity",0.2).hover(function() {
		<!-- $(this).stop(true,false).animate({"opacity":"0.5"},300);
	},function() {
		 $(this).stop(true,false).animate({"opacity":"0.2"},300);
	 });

	//上一页按钮
	$("#focus .pre").click(function() {
		index -= 1;
		if(index == -1) {index = len - 1;}
		showPics(index);
	});

	//下一页按钮
	$("#focus .next").click(function() {
		index += 1;
		if(index == len) {index = 0;}
		showPics(index);
	});

	//本例为左右滚动，即所有li元素都是在同一排向左浮动，所以这里需要计算出外围ul元素的宽度
	$("#focus ul").css("width",sWidth * (len));
	
	//鼠标滑上焦点图时停止自动播放，滑出时开始自动播放
	$("#focus").hover(function() {
		clearInterval(picTimer);
	},function() {
		picTimer = setInterval(function() {
			showPics(index);
			index++;
			if(index == len) {index = 0;}
		},3000); //此3000代表自动播放的间隔，单位：毫秒
	}).trigger("mouseleave");
	
	//显示图片函数，根据接收的index值显示相应的内容
	function showPics(index) { //普通切换
		var nowLeft = -index*sWidth; //根据index值计算ul元素的left值
		$("#focus ul").stop(true,false).animate({"left":nowLeft},300); //通过animate()调整ul元素滚动到计算出的position
		//$("#focus .btn span").removeClass("on").eq(index).addClass("on"); //为当前的按钮切换到选中的效果
		$("#focus .btn span").stop(true,false).animate({"opacity":"0.4"},300).eq(index).stop(true,false).animate({"opacity":"1"},300); //为当前的按钮切换到选中的效果
	}
});

</script>
	<div class="wrapper" style="height:350px">
		<div id="focus">
			<ul>
				<li><a href="#"><img src="{{ asset('Home/Images/20140902173833602.jpg')  }}" alt="HW商城" /></a></li>
				<li><a href="#"><img src="{{ asset('Home/Images/20140903183551979.jpg')  }}" alt="HW商城" /></a></li>
				<li><a href="#"><img src="{{ asset('Home/Images/20140902135825589.jpg')  }}" alt="HW商城" /></a></li>
				<li><a href="#"><img src="{{ asset('Home/Images/20140715104638522.jpg')  }}" alt="HW商城" /></a></li>
				<li><a href="#"><img src="{{ asset('Home/Images/20140702124823618.jpg')  }}" alt="HW商城" /></a></li>
			</ul>
		</div>
	</div><!-- wrapper end -->
</div>
<!-- 20130904-热门板-end -->

<div class="hr-20"></div>
<div class="layout">
	<div class="fl u-4-3">
<!-- 20130904-频道-优惠-start -->
<div class="channel-favorable">
	<ul class="channel-pro-list" id="main-sale-list">
		<volist name="hot" id="vo">
			@foreach($hot_sale as $v)
			<li id="1" class="channel-pro-item channel-pro-favorable-item-1">
				<div class="channel-pro-panels">
					
					<div class="pro-info">
						<div class="p-img">
							<a href="{{url('/home/goodinfo')}}/{{ $v->goods_id }}" title="{{ $v->index_sale_title }}" target="_blank"><img src="{{ asset('Admin/upload')}}/{{ $v->goods_big_pic }}" alt="#"></a>
						</div>
						<div class="p-name"><a href="/product/1348.html" title="#" target="_blank">
						{{ $v->index_sale_title }}</a></div>
						<div class="p-shining">
							<div class="p-slogan">{{ $v->index_sale_keywords }}</div>
						</div>
						<div class="p-price"><em>¥</em><span>{{ $v->goods_sale_price }}</span></div>
						<div class="p-button">
							<a href="{{url('/home/goodinfo')}}/{{ $v->goods_id }}" target="_blank" class="channel-button">立即抢购</a>
						</div>
						<div class="p-countdown hide">
							<span class="p-time"></span>
							<span class="p-quantity" style="display:none"></span>
						</div>						
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
					
				</div>
			</li>
			@endforeach
		</volist>
	</ul>
</div><!-- 20130904-频道-优惠-end --></div>
	<div class="fr u-4-1">
<!-- 20130904-频道-促销-start -->
<div class="channel-sale">
	<div class="ec-slider" id="group-slider" style="width: 276px; height: 310px;">
		<ul class="channel-pro-list ec-slider-list" id="slider-sale-list" style="width: 1656px; height: 310px;">
			<li class="channel-pro-item ec-slider-item" data-block="slider" style="width: 276px; height: 310px;">
				<p><a target="_blank" href="#"><img src="{{ asset('Home/Images/20140830182737537.jpg')  }}" title="荣耀6_联通购机送费.jpg')  }}"></a><br></p>
			</li>
		</ul>
	</div>
</div>

<!-- 20130904-频道-促销-end -->
		<div class="hr-20"></div>
		<!-- 新闻公告-start -->
		<div class="ecnews-area">
			<div class="h">
				<div class="h-tab">
					<ul>
						<li class="current" id="tab-notice"><a href="/notice-list">公告</a></li>
						<li id="tab-news"><a href="#">新闻</a></li>
					</ul>
				</div>
			</div>
			<div class="b">
				<ul id="tab-notice-content">
				@foreach($notice as $v)
					<li><a href="#" title="{{ $v->notice_title }}" target="_blank">{{ $v->notice_content }}</a></li>
				@endforeach	
				</ul>
				<ul id="tab-news-content" class="hide">
					<li><a href="/news-390" title="华为荣耀发布性价比神器荣耀3C畅玩版/平板" target="_blank">华为荣耀发布性价比神器荣耀3C畅玩版/平板</a></li>
					<li><a href="/news-384" title="华为大篷车亮相青海湖199公里磨砺青春麦芒" target="_blank">华为大篷车亮相青海湖199公里磨砺青春麦芒</a></li>
					<li><a href="/news-385" title="荣耀6成为国产最强爆款 比肩苹果三星" target="_blank">荣耀6成为国产最强爆款 比肩苹果三星</a></li>
					<li><a href="/news-321" title="双C设计，华为G6传承与突破" target="_blank">双C设计，华为G6传承与突破</a></li>
					<li><a href="/news-312" title="华为发布多款创新智能终端 4G生活无界限" target="_blank">华为发布多款创新智能终端 4G生活无界限</a></li>
				</ul>
			</div>
		</div><!-- 新闻公告-end -->
		<div class="hr-20"></div>
		<!-- 20130909-ad-218*132-start -->
		<div class="banner">
			<p><a target="_blank" href="#"><img src="{{ asset('Home/Images/20140509105527587.jpg')  }}"></a></p>
		</div><!-- 20130909-ad-218*132-start -->
		<div class="hr-20"></div>
	</div>
</div>
<div class="layout">
	<!-- 20130903-ad-1000*160-start -->
	<div class="banner">
		<!-- 20130903-ad-图片轮换-start -->
		<script type="text/javascript">
			$(function() {
			var sWidth = $("#focuss").width(); //获取焦点图的宽度（显示面积）
			var len = $("#focuss ul li").length; //获取焦点图个数
			var index = 0;
			var picTimer;
	
			//以下代码添加数字按钮和按钮后的半透明条，还有上一页、下一页两个按钮
			var btn = "<div class='btnBg'></div><div class='btn'>";
			for(var i=0; i < len; i++) {
			btn += "<span></span>";
			}
			btn += "</div><div class='preNext pre'></div><div class='preNext next'></div>";
			$("#focuss").append(btn);
			$("#focuss .btnBg").css("opacity",0.5);

			//为小按钮添加鼠标滑入事件，以显示相应的内容
			$("#focuss .btn span").css("opacity",0.4).mouseenter(function() {
				index = $("#focuss .btn span").index(this);
				showPics(index);
			}).eq(0).trigger("mouseenter");

			//上一页、下一页按钮透明度处理
			$("#focuss .preNext").css("opacity",0.2).hover(function() {
				$(this).stop(true,false).animate({"opacity":"0.5"},300);
			},function() {
				$(this).stop(true,false).animate({"opacity":"0.2"},300);
			});

			//上一页按钮
			$("#focuss .pre").click(function() {
				index -= 1;
				if(index == -1) {index = len - 1;}
				showPics(index);
			});

			//下一页按钮
			$("#focuss .next").click(function() {
				index += 1;
				if(index == len) {index = 0;}
				showPics(index);
			});

			//本例为左右滚动，即所有li元素都是在同一排向左浮动，所以这里需要计算出外围ul元素的宽度
			$("#focuss ul").css("width",sWidth * (len));
	
			//鼠标滑上焦点图时停止自动播放，滑出时开始自动播放
			$("#focuss").hover(function() {
				clearInterval(picTimer);
			},function() {
				picTimer = setInterval(function() {
					showPics(index);
					index++;
					if(index == len) {index = 0;}
				},3000); //此4000代表自动播放的间隔，单位：毫秒
			}).trigger("mouseleave");
	
			//显示图片函数，根据接收的index值显示相应的内容
			function showPics(index) { //普通切换
				var nowLeft = -index*sWidth; //根据index值计算ul元素的left值
				$("#focuss ul").stop(true,false).animate({"left":nowLeft},300); //通过animate()调整ul元素滚动到计算出的position
				//$("#focuss .btn span").removeClass("on").eq(index).addClass("on"); //为当前的按钮切换到选中的效果
				$("#focuss .btn span").stop(true,false).animate({"opacity":"0.4"},300).eq(index).stop(true,false).animate({"opacity":"1"},300); //为当前的按钮切换到选中的效果
			}
		});
		</script>
		<div class="wrapper" style="height:160px">
			<div id="focuss" style="height:160px">
				<ul>
					<li><a href="#"><img src="{{ asset('Home/Images/2014082514223543.jpg')  }}" alt="HW商城" /></a></li>
					<li><a href="#"><img src="{{ asset('Home/Images/20140701150453324.jpg')  }}" alt="HW商城" /></a></li>
					<li><a href="#"><img src="{{ asset('Home/Images/20140825143256198.jpg')  }}" alt="HW商城" /></a></li>
					<li><a href="#"><img src="{{ asset('Home/Images/20140830171414397.jpg')  }}" alt="HW商城" /></a></li>
					<li><a href="#"><img src="{{ asset('Home/Images/20140904180339478.jpg')  }}" alt="HW商城" /></a></li>
				</ul>
			</div>
		</div><!-- wrapper end -->
	</div><!-- 20130903-ad-1000*160-end -->
</div>
<div class="layout">
	<!-- 20130904-频道-楼层-start -->
	<div class="channel-floor">
		<div class="h">
			<h2><a href="javascript:void(0)" title="手机">手机</a></h2>
			<em class="channel-subtitle">华为精品手机</em>
			<ul class="channel-nav">
				<li><a href="javascript:void(0)" >手机</a></li>
				<li><a href="javascript:void(0)" >配件</a></li>
			</ul>
		</div>
		<div class="b">
			<ul class="channel-pro-list">
				<volist name="phone" id="vo" key="k">
					@foreach($phone_sale as $v)
						@if($v->goods_id == 23)
						<li id="{{ $v->goods_id }}" class="channel-pro-item channel-pro-rec-item">
							<div class="channel-pro-panels">
								<div class="pro-info">
									<div class="p-img">
										<a href="{{url('/home/goodinfo')}}/{{ $v->goods_id }}" title="{$vo.index_sale_title}" target="_blank" rel="nofollow">
											<img src="{{ asset('Admin/upload')}}/{{ $v->goods_big_pic }}">
										</a>
									</div>
									<div class="p-name">
										<a href="" title="#" target="_blank">
									{{ $v->index_sale_title }}
										</a>
									</div>
									<div class="p-shining">
										<div class="p-slogan">{{ $v->index_sale_keywords }}</div>
										<div class="p-promotions">尊享配件豪礼</div>
									</div>
									<div class="p-price"><em>¥</em><span>{{ $v->goods_sale_price }}</span></div>
									<div class="p-button">
										<a href="{{url('/home/goodinfo')}}/{{ $v->goods_id }}" target="_blank" class="channel-button" title="立即抢购">立即抢购</a>
									</div>
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
							</div>
						</li>
						@else
						<li id="{{ $v->goods_id }}" class="channel-pro-item">
							<div class="channel-pro-panels">
								<div class="pro-info">
									<div class="p-img">
										<a href="{{url('/home/goodinfo')}}/{{ $v->goods_id }}" title="{{ $v->index_sale_title }}" target="_blank" rel="nofollow">
											<img alt="" src="{{ asset('Admin/upload')}}/{{ $v->goods_big_pic }}">
										</a>
									</div>
									<div class="p-name">
										<a href="{{url('/home/goodinfo')}}/{{ $v->goods_id }}" title="{{ $v->index_sale_title }}" target="_blank">
									     {{ $v->index_sale_title }}
											<span class="p-slogan">{{ $v->index_sale_keywords }}</span>
										</a>
									</div>
									<div class="p-price"><em>¥</em><span>{{ $v->goods_sale_price }}</span></div>
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
							</div>
						</li>
						@endif
					@endforeach
				</volist>
			</ul>
		</div>
	</div><!-- 20130904-频道-楼层-end -->
</div>
<div class="hr-20"></div>
<div class="layout">
	<!-- 20130904-频道-楼层-start -->
	<div class="channel-floor">
		<div class="h">
			<h2><a href="javascript:void(0)" title="平板电脑" target="_blank">平板电脑</a></h2>
			<em class="channel-subtitle">华为精品平板</em>
			<ul class="channel-nav">
				<li><a href="/list-9#10" target="_blank">平板电脑</a></li>
				<li><a href="/list-9#11" target="_blank">配件</a></li>
			</ul>
		</div>
		<div class="b">
			<ul class="channel-pro-list">
			  <volist name="compt" id="vo" key="k">
			  	@foreach($ipad_sale as $v)
					@if($v->goods_id == 26)
						<li id="{{ $v->index_sale_id }}" class="channel-pro-item channel-pro-rec-item">
							<div class="channel-pro-panels">
								<div class="pro-info">
									<div class="p-img">
										<a href="{{url('/home/goodinfo')}}/{{ $v->goods_id }}" title="{{ $v->index_sale_title }}" target="_blank" rel="nofollow">
											<img src="{{ asset('Admin/upload')}}/{{ $v->goods_big_pic }}">
										</a>
									</div>
									<div class="p-name">
										<a href="" title="#" target="_blank">
									{{ $v->index_sale_title }}
										</a>
									</div>
									<div class="p-shining">
										<div class="p-slogan">{{ $v->index_sale_keywords }}</div>
									</div>
									<div class="p-price"><em>¥</em><span>{{ $v->goods_sale_price }}</span></div>
									<div class="p-button">
										<a href="{{url('/home/goodinfo')}}/{{ $v->goods_id }}" target="_blank" class="channel-button" title="立即抢购">立即抢购</a>
									</div>			
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
							</div>
						</li>
					@else
						<li id="{{ $v->index_sale_id }}" class="channel-pro-item">
							<div class="channel-pro-panels">
								<div class="pro-info">
									<div class="p-img">
										<a href="{{url('/home/goodinfo')}}/{{ $v->goods_id }}" title="{{ $v->index_sale_title }}" target="_blank" rel="nofollow">
											<img src="{{ asset('Admin/upload')}}/{{ $v->goods_big_pic }}">
										</a>
									</div>
									<div class="p-name">
										<a href="{{url('/home/goodinfo')}}/{{ $v->goods_id }}" title="{{ $v->index_sale_title }}" target="_blank">
									{{ $v->index_sale_title }}
											<span class="p-slogan">{{ $v->index_sale_keywords }}</span>
										</a>
									</div>
									<div class="p-price"><em>¥</em><span>{{ $v->goods_sale_price }}</span></div>
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
							</div>
						</li>
					@endif
				@endforeach
				</volist>
			</ul>
		</div>
	</div><!-- 20130904-频道-楼层-end -->
</div>
<div class="hr-20"></div>
<div class="layout">
	<!-- 20130903-ad-762*132-start -->
	<div class="ad fl"><a target="_blank" href="#"><img src="{{ asset('Home/Images/20140825101353417.jpg')  }}" title="M1" style="float:none;"></a></div>
	<!-- 20130903-ad-762*132-end -->
</div>
<div class="hr-40"></div>
<!-- 20130902-关注-start -->
<div class="follow">
	<div class="layout">
		<ul>
			<li><a href="#" class="follow-sina"><img alt="关注新浪微博" src="{{ asset('Home/Images/follow_sina.png')  }}"></a></li>
			<li><a href="#" class="follow-weibo"><img alt="关注腾讯微博" src="{{ asset('Home/Images/follow_weibo.png')  }}"></a></li>
			<li onmouseout="this.className=''" onmouseover="this.className='hover'" class=""><a href="javascript:;" class="follow-android"><img alt="下载手机客户端" src="{{ asset('Home/Images/follow_android.png')  }}"></a><div class="follow-panel follow-panel-qrcode"><img src="{{ asset('Home/Images/img67.png')  }}"><p><b>扫描二维码下载</b></p><s></s></div></li>
		</ul>
	</div>
</div>
<!-- 20130902-关注-end -->

<div id="globleParameter" class="hide" context="" stylepath="{{ asset('Home/Css') }}" scriptpath="{{ asset('Home/Js') }}" imagepath="{{ asset('Home/Images') }}" mediapath="{{ asset('Home/Images') }}"></div>
<!--底部 -->
<footer class="footer">
    <!-- 20130902-底部-友情链接-start -->
	<div class="footer-otherLink">
		<p style="text-align:left;">
		<span style="line-height:1.5;">
		<span style="font-family:宋体;"> 友情链接：</span></span>
		<span style="line-height:1.5;">
		<span style="font-family:宋体;">
		<a href="#" target="_blank">华为官网</a>
		<volist name="links" id="vo">
		@foreach($link as $v)
		 | <a href="{{ $v->links_url }}" target="_blank" style="line-height:1.5;font-family:宋体;">{{ $v->links_name }}</a> <span style="line-height:1.5;font-family:宋体;"> 
		@endforeach
		</volist>
		<a href="{{ url('homeLinks/Index') }}" target="_blank" style="line-height:1.5;font-family:宋体;">申请友情链接>></a> <span style="line-height:1.5;font-family:宋体;">
		<br></p>
	</div>
	<div class="footer-warrant-area"><p>Copyright © 2011-2013  华为软件技术有限公司  版权所有  保留一切权利  苏B2-20130048号 | 苏ICP备09062682号-9            </p><p><a target="_blank" href="{{ asset('Home/Images/wwwz.jpg')  }}">网络文化经营许可证苏网文[2012]0401-019号</a></p><p class="footer-warrant-img">   <a href="#" target="_blank"><img title="经营性网站" alt="经营性网站" src="{{ asset('Home/Images/certificate_01_112_40.png')  }}"></a> <a title="诚信网站" href="#" rel="nofollow" target="_blank"><img alt="诚信网站" src="{{ asset('Home/Images/certificate_02_112_40.png')  }}"></a> <a title="诚信网站" href="#" rel="nofollow" target="_blank"><img alt="诚信网站" src="{{ asset('Home/Images/certificate_03_112_40.png')  }}"></a></p></div><!--授权结束 -->
</footer>
<!--Hit 2014-09-02 00:15:31,1-->
<div id="AutocompleteContainter_92ea" style="position: absolute; z-index: 9999; top: 503px; left: 556.5px;">
	<div class="autocomplete-w1">
		<div class="autocomplete" id="Autocomplete_92ea" style="display: none; width: 315px; max-height: 400px;"></div>
	</div>
</div>
</body>
</html>
@endsection