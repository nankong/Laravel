@extends('Home.base.parent1')
@section('title')
		<title>商品详情</title>
		<meta name='csrf-token' content="{{ csrf_token() }}">
		<link href="{{ asset('Extends/AmazeUI-2.4.2/assets/css/admin.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('Extends/AmazeUI-2.4.2/assets/css/amazeui.css') }}" rel="stylesheet" type="text/css" />
		<!-- <link href="{{ asset('Extends/basic/css/demo.css') }}" rel="stylesheet" type="text/css" /> -->
		<link type="text/css" href="{{ asset('Extends/css/optstyle.css') }}" rel="stylesheet" />
		<link type="text/css" href="{{ asset('Extends/css/style.css') }}" rel="stylesheet" />

		<script type="text/javascript" src="{{ asset('Extends/basic/js/jquery-1.7.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('Extends/basic/js/quick_links.js') }}"></script>

		<script type="text/javascript" src="{{ asset('Extends/AmazeUI-2.4.2/assets/js/amazeui.js') }}"></script>
		<script type="text/javascript" src="{{ asset('Extends/js/jquery.imagezoom.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('Extends/js/jquery.flexslider.js') }}"></script>
		<script type="text/javascript" src="{{ asset('Extends/js/list.js') }}"></script>

@endsection
@section('bodycss')
<body class="wide detail">
@endsection
@section('content')

				<ol class="am-breadcrumb am-breadcrumb-slash">
					<li><a href="/">首页</a></li>
					<li>{{ $ob->goods_name }}</li>
				
				</ol>
				<script type="text/javascript">
					$(function() {});
					$(window).load(function() {
						$('.flexslider').flexslider({
							animation: "slide",
							start: function(slider) {
								$('body').removeClass('loading');
							}
						});
					});
				</script>
				<div class="scoll">
					<section class="slider">
						<div class="flexslider">
							<ul class="slides">
								<li>
									<img src="{{ asset('Admin/upload')}}/{{ $ob->goods_big_pic}}" title="pic" />
								</li>
								
							</ul>
						</div>
					</section>
				</div>

				<!--放大镜-->

				<div class="item-inform">
					<div class="clearfixLeft" id="clearcontent">

						<div class="box">
							<script type="text/javascript">
								$(document).ready(function() {
									$(".jaqzoom").imagezoom();
									$("#thumblist li a").click(function() {
										$(this).parents("li").addClass("tb-selected").siblings().removeClass("tb-selected");
									
									});
								});
							</script>

							<div class="tb-booth tb-pic tb-s310">
								<a href="{{ asset('Admin/upload')}}/{{ $ob->goods_big_pic}}"><img src="{{ asset('Admin/upload')}}/{{ $ob->goods_big_pic}}" alt="细节展示放大镜特效" rel="{{ asset('Admin/upload')}}/{{ $ob->goods_big_pic}}" class="jaqzoom" /></a>
							</div>
							<ul class="tb-thumb" id="thumblist">
								<li class="tb-selected">
									<div class="tb-pic tb-s40">
										<a href="#"><img src="{{ asset('Admin/upload')}}/{{ $ob->goods_big_pic}}" mid="../images/01_mid.jpg" big="../images/01.jpg"></a>
									</div>
								</li>
								
							</ul>
						</div>

						<div class="clear"></div>
					</div>

					<div class="clearfixRight">

						<!--规格属性-->
						<!--名称-->
						<div class="tb-detail-hd">
							<h1>	
				 {{ $ob->goods_name }}
	          </h1>
	          <div class="pro-slogan" id="skuPromWord" style="color:red;font-size:20px;">{{ $ob->goods_keywords }}</div>
						</div>
						<div class="tb-detail-list">
							<!--价格-->
							<div class="tb-detail-price">
								<li class="price iteminfo_price">
									<dt><label>华&nbsp;为&nbsp;&nbsp;价：</label></dt>
									<dd><em>¥</em><b class="sys_item_price">{{ $ob->goods_sale_price }}</b>  </dd>                                 
								</li>
								
						     </div>
						     	<div class="pro-freight"><label>运&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;费：</label>
									<span style="color:red;">满&nbsp;200&nbsp;免运费</span>

								</div>
						     	<div class="pro-service"><label>服&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;务：</label>由华为商城负责发货，并提供售后服务</div>
								
								<div class="clear"></div>
						</div>

							
							<div class="clear"></div>

							
							<div class="clear"></div>

							<!--各种规格-->
							<dl class="iteminfo_parameter sys_item_specpara">
								
								
									<!--操作页面-->

									<div class="theme-popover-mask"></div>

									<div class="theme-popover">
										<div class="theme-span"></div>
										<div class="theme-poptit">
											<a href="javascript:;" title="关闭" class="close">×</a>
										</div>
										<div class="theme-popbod dform">
											<form class="theme-signin" name="loginform" action="" method="post">

												<div class="theme-signin-left">

													
													<div class="theme-options">
														<div class="cart-title number">数量</div>
														<dd>
															<input title="减"  id="min" class="am-btn am-btn-default" name="" type="button" value="-" />
															<input id="text_box" class="pro-quantity" name="" type="text" value="1" style="width:30px;" />
															<input title="加" id="add" class="am-btn am-btn-default" name="" type="button" value="+" />
															<span id="Stock" class="tb-hidden">库存<span class="stock">{{ $ob->goods_num }}</span>件</span>
														</dd>


													</div>
													<div class="clear"></div>

													
												</div>
												

											</form>
										</div>
									</div>

								</dd>
							</dl>
							<div class="clear"></div>
							<!--活动	-->
							<div class="shopPromotion gold">
								
								<div class="clear"></div>
								
							</div>
						</div>

						<div class="pay">
							<div class="pay-opt">
							
							
							</div>
							<li>
								<div class="clearfix tb-btn tb-btn-buy theme-login">
									<a id="LikdoBuy" title="点此按钮到下一步确认购买信息" href="javascript:;">立即购买</a>
								</div>
							</li>
							<li>
								<div class="clearfix tb-btn tb-btn-basket theme-login" style="visibility: visible;">
									<a id="LikBasket" class="button-add-cart" title="加入购物车" href="javascript:;"><i></i>加入购物车</a>
								</div>

							</li>
							<li>
								<div class="clearfix tb-btn tb-btn-buy theme-login" style="background:red;">
									<a id="LikBuy" title="点此按钮到下一步确认购买信息" href="/home/cart/index">购物车结算</a>
								</div>
							</li>
							<li>
								<div class="clearfix tb-btn tb-btn-buy theme-login" style="background:red;">
									<a id="collect_a" title="点此按钮到下一步确认购买信息" href="javascript:;">收藏它</a>
								</div>
							</li>
							<li>
								<div class="clearfix tb-btn tb-btn-buy theme-login" style="background:red;">
									<a id="collect_b" title="点此按钮到下一步确认购买信息" href="javascript:;">浏览收藏</a>
								</div>
							</li>
						</div>

					</div>

					<input type="hidden"  name="goods_id" value="{{ $ob->goods_id }}" id="goods_id" />
					<input type="hidden" name="goods_state_login"  value="{{ $ob->goods_num }}" id="goods_state_login"/>
					<script type="text/javascript" src="{{ asset('Home/Js/do_cat.js') }}"></script>
					<script type="text/javascript" src="{{ asset('Home/Jquery/jquery-1.7.2.js') }}"></script> 

					<script type="text/javascript">
						


 						$(function(){
			             //ajax 实现购物车的功能
						 //获取商品的id 和状态
		 
						var goods_id=$("#goods_id").val();
				   	 	var goods_state_login=$("#goods_state_login").val();
						var goods_total=parseInt($(".stock").html());
		  				// alert(goods_total);
		  				// -------------加入收藏-------------------------
		  				$("#collect_a").click(function(){
		  						$.ajaxSetup({
	                                headers: {
	                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	                                	}
	                                });
		  						$.ajax({
		  							url:'/home/collect/add',
		  							type:'POST',
		  							dataType:'json',
		  							data:{
		  								'goods_id':goods_id,
		  							},
		  							success:function(responseText,status,xhr){
		  								console.log(responseText);
		  								if(status == 'success'){
		  									if(responseText == 1){
		  										alert('收藏成功');
		  									}else if(responseText == 0){
		  										alert('请先登入');
		  									}else{
		  										alert('已收藏');
		  									}
		  								}else{
		  									alert('收藏失败1');
		  								}
		  							},
		  							error:function(){
		  								alert('收藏失败2');
		  							}
		  						})
		  				})
		  				//-----------------------------------浏览收藏-------------
		  				$("#collect_b").click(function(){
		  						$.ajaxSetup({
	                                headers: {
	                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	                                	}
	                                });
		  						$.ajax({
		  							url:'/home/collect/index',
		  							type:'POST',
		  							dataType:'json',
		  							data:{
		  								'goods_id':goods_id,
		  							},
		  							success:function(responseText,status,xhr){
		  								console.log(responseText);
		  								if(status == 'success'){
		  									if(responseText == 1){
		  										 window.location.href ='/home/collect/look';
		  									}else{
		  										alert('请先登入');
		  									}
		  								}else{
		  									alert('浏览失败1');
		  								}
		  							},
		  							error:function(){
		  								alert('浏览失败2');
		  							}
		  						})
		  				})
		  				//---------------------立即购买----------------------
		   				$("#LikdoBuy").click(function(){
		   					if(goods_state_login == 0){
		   						alert('商品已经下架,不可以购买');
		   					}else{
		   						//可以购买的就ajax的形式传到后台
							    // 商品的id 和数量
							    var num=$(".pro-quantity").val();
							    if(num<1){
							    	alert('你选取的数量小于1');
							    }else if(num>goods_total){
							    	alert('库存不足,少买点吧');
							    }else{
							    	//ajax处理
				 					$.ajaxSetup({
	                                headers: {
	                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	                                	}
	                                });
	                               	$.ajax({
	                               		url:'/home/buy',
	                               		type:'POST',
	                               		dataType:'json',
	                               		data:{
	                               			'num':num,
									  		'goods_id':goods_id,
	                               		},
	                               		success:function(responseText,status,xhr){
								   		    console.log(responseText);
								   		    if(status == 'success'){
								   		    	if(responseText== 1){
								   		    		window.location.href="/home/gobuy";
								   		    	}else{
								   		    		alert('购买失败2');
								   		    	}
								   		    }
								   		},
								   		    error:function(){
								   		    	alert('购买失败3');
								   		    }

	                               		
	                            	});
							    }
		   					}
		   				})
		   
		   				//--------------------------加入购物车-------------------------
						$("#LikBasket").click(function(){
								      //ajax去结算
									 //先判断是否下架
							// alert(goods_state_login);
							
						    if(goods_state_login==0){
							     alert("商品已经下架,不可以购买!");
							
							}else{
							  //可以购买的就ajax的形式传到后台
							  // 商品的id 和数量
							  
							  var num=$(".pro-quantity").val();
							  // alert(num);
							  if(num<1){
							      alert('你选取的数量小于1');
				  
				  
				  			  }else if(num>goods_total){
				  
				      	        alert('库存不足,少买点吧');
				  
				            }else{
				      			//ajax处理
			 					$.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                	}
                            	});
								$.ajax({
							       url:"/home/goodsadd",
								   type:'POST',
								   data:{
								      'num':num,
									  'goods_id':goods_id,
								   
								   },
								   dataType:'json',
								   success:function(responseText,status,xhr){
								   		console.log(responseText);
								       if(status=='success'){
									      if(responseText.status==1){
										  
										       // 成功
											   // $("#cart-total").html(responseText.content.temprory_num);
											   // $("#cart-price").html(responseText.content.temprory_price.toFixed(2));
											   // $(".pro-popup-area").css('display','block');
											   do_cat('/home/smallcat/mygoods');
											   // do_cat();
											   alert('加入购物车成功');
											   
											   
										  }else{
										    alert('加入购物车失败');
										  }
									   
									   }else{
									      alert('加入购物车失败');
									   
									   }
								   
								   },
								   error:function(){
								      alert("购买失败");
								   
								   },
								   timeout:1000*60,
							  
							  });
						  
						
						
					}		
				
				}	  
						
					  
		  });
		 
	
		 
		 
		 
 
 
 });	







</script>	
					 
					<div class="clear"></div>

				</div>

				
				<div class="clear"></div>
				
							
				<!-- introduce-->

				<div class="introduce">
					<div class="browse">
					    <div class="mc"> 
						     <ul>					    
						     	<div class="mt">            
						            <h2>最新上架</h2>        
					            </div>
						     	@foreach( $new as $n )
							      <li class="first">
							      	<div class="p-img">                    
							      		<a  href="/home/goodinfo/{{ $n->goods_id }}"> <img class="" src="{{ asset('Admin/upload')}}/{{ $n->goods_big_pic}}"> </a>               
							      	</div>
							      	<div class="p-name"><a href="/home/goodinfo/{{ $n->goods_id }}">
							      		{{ $n->goods_name }}
							      	</a>
							      	</div>
							      	<div class="p-price"><strong>¥{{ $n->goods_sale_price }}</strong></div>
							      </li>
							    @endforeach  						      
					      		
						     </ul>
						     
					    </div>
					</div>
					<div class="introduceMain">
						<div class="am-tabs" data-am-tabs>
							<ul class="am-avg-sm-3 am-tabs-nav am-nav am-nav-tabs">
								<li class="am-active">
									<a href="#">

										<span class="index-needs-dt-txt">宝贝详情</span></a>

								</li>

								<li>
									<a href="#">

										<span class="index-needs-dt-txt">全部评价</span></a>

								</li>

								<li>
									<a href="#">

										<span class="index-needs-dt-txt">包装清单</span></a>
								</li>
							</ul>

							<div class="am-tabs-bd">

								<div class="am-tab-panel am-fade am-in am-active">
									<div class="J_Brand">

										<div class="attr-list-hd tm-clear">
											<h4>产品参数：</h4></div>
										<div class="clear"></div>
										<ul id="J_AttrUL">
											<li title="">品牌:&nbsp;华为</li>
											<li title="">上市时间:&nbsp;{{ date('Y-m-d H:i:s',$ob->goods_time) }}</li>
											<li title="">商品状态:&nbsp;{{ $ob->goods_state }}</li>
											
										</ul>
										<div class="clear"></div>
									</div>

									<div class="details">
										<div class="attr-list-hd after-market-hd">
											<h4>商品细节</h4>
										</div>
										<div class="twlistNews">
											
										</div>
									</div>
									<div class="clear"></div>

								</div>

								<div class="am-tab-panel am-fade">
									
                                    <div class="actor-new">
                                    	<div class="rate">                
                                    		<strong>100<span>%</span></strong><br> <span>好评度</span>            
                                    	</div>
                                        <dl>                    
                                            <dt>买家印象</dt>                    
                                            <dd class="p-bfc">
                                            			
                                            			<q class="comm-tags"><span>商品不错</span><em>(1689)</em></q>
                                            			<q class="comm-tags"><span>价格便宜</span><em>(1119)</em></q>
                                            			<q class="comm-tags"><span>特价买的</span><em>(865)</em></q>
                                            			 
                                            </dd>                                           
                                         </dl> 
                                    </div>	
                                    <div class="clear"></div>
									<div class="tb-r-filter-bar">
										<ul class=" tb-taglist am-avg-sm-4">
											<li class="tb-taglist-li tb-taglist-li-current">
												<div class="comment-info">
													<span>全部评价</span>
													<span class="tb-tbcr-num">(32)</span>
												</div>
											</li>

											<li class="tb-taglist-li tb-taglist-li-1">
												<div class="comment-info">
													<span>好评</span>
													<span class="tb-tbcr-num">(32)</span>
												</div>
											</li>

											<li class="tb-taglist-li tb-taglist-li-0">
												<div class="comment-info">
													<span>中评</span>
													<span class="tb-tbcr-num">(32)</span>
												</div>
											</li>

											<li class="tb-taglist-li tb-taglist-li--1">
												<div class="comment-info">
													<span>差评</span>
													<span class="tb-tbcr-num">(32)</span>
												</div>
											</li>
										</ul>
									</div>
									<div class="clear"></div>
									@foreach( $user as $v)
									<ul class="am-comments-list am-comments-list-flip">
										<li class="am-comment">
											<!-- 评论容器 -->
											
												
												<!-- 评论者头像 -->
											

											<div class="am-comment-main">
												<!-- 评论内容容器 -->
												<header class="am-comment-hd">
													<!--<h3 class="am-comment-title">评论标题</h3>-->
													<div class="am-comment-meta">
														<!-- 评论元数据 -->
														{{ $v->user_username}}
														<a href="#link-to-user" class="am-comment-author"></a>
														<!-- 评论者 -->
														评论于
														<time datetime="">{{ date('Y-m-d H:i:s',$v->comment_pubtime) }}</time>
													</div>
												</header>

												<div class="am-comment-bd">
													<div class="tb-rev-item " data-id="255776406962">
														<div class="J_TbcRate_ReviewContent tb-tbcr-content ">
															{{ $v->comment_body }}
														</div>
														
													</div>

												</div>
												<!-- 评论内容 -->
											</div>
										</li>
									@endforeach
									</ul>
									<div class="clear"></div>

									<!--分页 -->
									
									<div class="clear"></div>

									<div class="tb-reviewsft">
										<div class="tb-rate-alert type-attention">购买前请查看该商品的购物保障，明确您的售后保障权益。</div>
									</div>

								</div>

								<div class="am-tab-panel am-fade">
									<div class="like">
										<ul >
											<li>
												<div>
													
													<p>手机 x 1，充电器 x 1，USB 线 x 1，快速指南 x 1，售后服务手册 x 1，取卡针 x 1，屏幕保护膜（出厂已贴在手机上） x 1
														</p>
													
														
												
												</div>
											</li>
											
										</ul>
									</div>
									<div class="clear"></div>

									<!--分页 -->
									<ul class="am-pagination am-pagination-right">
										
									</ul>
									<div class="clear"></div>

								</div>

							</div>

						</div>

						<div class="clear"></div>

						
					</div>

				</div>
			</div>
@endsection