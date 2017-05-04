@extends('Home.base.parent')
@section('title')
	<meta http-equiv="Content-Language" content="zh-cn">
	<meta name='csrf-token' content="{{ csrf_token() }}"> 
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<title>我的订单_个人中心_华为商城</title>
	<style>
		#list-pager .current{
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
		#list-pager .num{
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
		#list-pager .prev{
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
		#list-pager .next{
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
@section('content')
<div class="hr-10"></div>
<div class="g">
	@if(session('msg'))
        <script>
        window.onload=function(){
        	var msg = "{{ session('msg') }}";
        	alert(msg);
        }
        ; 
       </script>
    @endif
	<!--面包屑 -->
	<div class="breadcrumb-area icon-breadcrumb fcn">您现在的位置：
		<a href="{{ url('/') }}" title="首页">首页</a>&nbsp;&gt;&nbsp;
		<span id="personCenter"><a href="{{ url('home/member') }}" title="个人中心">个人中心</a></span>
		<span id="pathPoint">&nbsp;&gt;&nbsp;</span>
		<b id="pathTitle">我的订单</b>
	</div>
</div>
<div class="hr-15"></div>
<div class="g">
    <div class="fr u-4-5"><!--栏目 -->
<div class="part-area clearfix">
    <div class="fl">
        <h3 class="myOrders-title"><span>我的订单</span></h3>        
   	 </div>
    </div>

<div class="hr-3"></div>
<!--我的订单 -->
<div class="myOrders-area">
	<div class="myOrders-title-area">
        <div class="h clearfix">
            <div class="fl">
                <div class="h-tab">
                    <ul>
                        
                    </ul>
                </div>
            </div>
        </div>
        <div class="b">
            <table border="0" cellpadding="0" cellspacing="0" id="order-list-head">
                <thead>
                    <tr>
                        <th>商品及订单号</th>
                        <th class="tr-span-3">单价<em>/元</em></th>
                        <th class="tr-span-2">数量</th>
                        <th class="tr-span-4 operate">订单状态及操作</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div class="hr-2"></div>
    <!-------------------以上为订单头部---------------------------------->
    <div id="myOrders-list-content">
        <div class="myOrders-list">
    @foreach($list as $k=>$v)
    	<!--我的订单-订单-套餐 -->
		 <volist name="list" id="vo">
	    	<div class="myOrders-pro-area">
	        	<div class="h clearfix">
	                <table border="0" cellpadding="0" cellspacing="0">
	                    <tbody>
	                        <tr>
	                            <td class="tal">
	                            	订单编号：<a href="javascript:void(0)" title="{{ $v->order_od_numb }}">{{ $v->order_od_numb }}</a>
	                            	&nbsp;&nbsp;&nbsp;&nbsp;
	                            	生成时间：{{ date('Y-m-d H:i:s', $v->order_time) }}
									&nbsp;&nbsp;&nbsp;&nbsp;
	                            </td>
	                            <td class="tr-span-4">
									<em>
									@if($v->order_state == 0)
									    待付款
									@elseif($v->order_state == 1)
									    已付款
									@elseif($v->order_state == 2)
									    待发货
									@elseif($v->order_state == 3)
										已发货
									@elseif($v->order_state == 4)
									    待收货
									@elseif($v->order_state == 5)
										已收货
									@endif
									</em>
								</td>
	                        </tr>
	                	</tbody>
	                </table>  
	            </div>
	            <div class="b">
	            	<table border="0" cellpadding="0" cellspacing="0">
	                    <tbody>
	                        <!-- 组合套餐列表 -->

							<!-- 普通商品列表 -->
							<volist name="vo['goods']" id='goods'>
	                        <tr>
	                            <td class="tal">
	                                <div class="pro-area clearfix">
	                                    <p class="p-img">
	                                    	<a title="{{ $v->order_goodsid }}" href="/home/goodinfo/{{ $v->order_goodsid }}" target="_blank">
	                                    	<img alt="{{ $v->order_goodsnam }}" src="{{ asset('Admin/upload') }}/{{ $v->order_goodspic }}">
	                                        
	                                    	</a>
	                                    </p>
	                                    <p class="p-name">
	                                    	<a title="{$goods_name}" target="_blank" href="#">{{ $v->order_goodsnam }}</a>
	                                    </p>        
	                                </div>
	                            </td>
	                            <td class="tr-span-3">{{ $v->order_price }}</td>                       
	                            <td class="tr-span-2">{{ $v->order_goodsnum }}</td>
								<td rowspan="2" class="tr-span-4 operate">
									@if($v->order_state == 0)
								   		<a href="{{ url('/home/cart/confirmcart') }}/{{ $v->order_od_numb }}">去付款</a>
								   
								    @elseif($v->order_state == 1)
										    正在发货中
									@elseif($v->order_state == 3)
										
									   <input type="hidden" value="{{ $v->order_goodsid }}"/>
								       <a href="javascript:void(0);" class="recOreder">去收货</a>
										     
									@elseif($v->order_state == 5)
									   <input type="hidden" value="{{ $v->order_goodsid }}"/>
									    <a href="javascript:void(0)" id="a" class="comment">去评价</a>
									@elseif($v->order_state == 6)
										交易完成
									@endif		
								</td>
	                        </tr>
	                        </volist>    
						   <!-- 普通商品列表 end -->
	                    </tbody>
	                </table>
	            </div>
	        </div>
			</volist>
			@endforeach	
        </div>
    </div>
    {{ $list->links() }}
    <div class="myAddress-add-area">
    <div class="b" id='t' style="display:none">
    <script>
    	$('#a').mouseover(function(){
    		$('#a').css('cursor','pointer');
    	});
    </script>
    	<div class="form-edit-area">
	    <form id="myAddress-add-form" action="{{ url('/home/addcomment') }}" autocomplete="off" method="post" onsubmit="return ec.member.myAddress.save(this)" data-type="add">
	    <input type="hidden" name='comment_gid' class="comment_gid" value="">
	    <input type="hidden" name='comment_pubtime' value=''>
	    <input type="hidden" name='comment_uid' value=''>
	    <script>
	    	$(".comment").click(function(){
	    		// alert(111);
		    var order_id=$(this).prev('input').val();
		    $(".comment_gid").attr('value',order_id);
		    // alert($(".comment_gid").attr('value'));
		});
	    </script>
		{{ csrf_field() }}
            <div class="form-edit-table">
                    <table border="0" cellpadding="0" cellspacing="0">
                        <tbody> 
                        <tr>
                        评分等级
                        	<select name='comment_classify'>
                        		<option value='1'>1</option>
                        		<option value='2'>2</option>
                        		<option value='3'>3</option>
                        		<option value='4'>4</option>
                        		<option value='5'>5</option>
                        	</select>
                        </tr>   
                        <tr>
                            <td>请输入评论内容
                            
							
							<input maxlength="100" type="text" class="text vam span-400" required name="comment_body" validator="validator21409811718554" id="input_label_0" style="z-index: 1;margin:3px 0 0 5px;" placeholder="评论内容"></td>
                        </tr>
                        <input type="hidden" name="randomFlag" required value="afc754d880d6b5786012c28eeb3d058f">
                    </tbody></table>
            </div>
            <div class="form-edit-action"><input type="submit" id='ok' class="button-action-ok-2 vam" value="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" class="button-action-cancel-2 vam" value="" onclick="ec.member.myAddress.reset()"></div>
	    </form>
        </div>
    </div>
</div>
<script>
	$('#a').click(function(){
    	$('#t').toggle(1900);
    });
</script>
<script type="text/javascript">
   $(function(){
         //收货的ajax处理
        $(".recOreder").click(function(){
		    var order_id=$(this).prev('input').val();
		    // alert(order_id);
			var value=confirm("你确定要收货吗?");			
			if(value){
				$.ajaxSetup({
	                headers: {
	                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	            	}
	        	});
			     $.ajax({
				     url:"/home/yesorder",
					 type:'POST',
					 data:{
					     'order_id':order_id,
					 },
					 success:function(responseText,status,xhr){
					 	console.log(responseText);
					     if(status=='success'){
						      if(responseText==1){
							     window.location.reload();
								 alert("收货成功!");
							  }else{
							     alert("收货失败");
							  }
						 }else{
						    alert("收货失败");
						 } 
					 },
					 error:function(){
					      alert("收货失败");
					 },
					 timeout:60*1000,
				 });
			}	
		});   
   });
</script>
    <div class="hr-5"></div>   
</div>
<input type="hidden" id="colid" value="0">
</div>
@endsection