@extends('Home.base.parent')
@section('title')
	<meta name='csrf-token' content="{{ csrf_token() }}">
	<title>个人购物地址_华为商城</title>
	<style>
		.button-del{
			/*width:50px;*/
			padding: 4px;
			margin-right: 5px;
			margin-top:4px;
			background:#fff;
			border:1px solid #eee;
			border-radius: 5px;
			box-shadow: 0 2px 12px #eee;
			cursor: pointer; 
			letter-spacing: 1px;
		}
		.mytest{
			border:1px solid red;
		}
	</style>
@endsection
@section('content')

<div class="hr-10"></div>
<div class="g" >
	<!--面包屑 -->
	<div class="breadcrumb-area icon-breadcrumb fcn">您现在的位置：
		<a href="{{ url('/') }}" title="首页">首页</a>&nbsp;&gt;&nbsp;
		<span id="personCenter"><a href="{{ url('home/member') }}" title="个人中心">个人中心</a></span>
		<span id="pathPoint">&nbsp;&gt;&nbsp;</span>
		<b id="pathTitle">收货信息</b>
	</div>
</div>
<div class="hr-15"></div>

<div class="g">
    <div class="fr u-4-5"><!--栏目 -->
<div class="part-area clearfix">
    <div class="fl">
        <h3 class="myAddress-title"><span>我的收货地址</span></h3>
    </div>
</div>
<div class="hr-2"></div>
<!--表单-我的收货地址 -->
<div class="myAddress-list" id='content'>
	<volist name="address_info" id="vo">
	<div id="myAddress-area-8543557" class="myAddress-area">
	@if(session('msg'))
        <script>
        window.onload=function(){
        	var msg = "{{ session('msg') }}";
        	alert(msg)
        }
        ; 
       </script>
    @endif
	@foreach($list as $v)
	<div class="h clearfix">
		<div class="fl" id="tip">
		   @if($v->address_default == 1)
			<b>已设为默认地址</b>
			  <b></b>
		   @endif
		</div>
	    <div class="fr">
	    @if($v->address_default == 0)
	        <button  class="button-del" value="{{ $v->address_id }}"  onclick='dodef(this.value)' title="默认地址">设为默认</button>
	    @endif
		    <button  class="button-del" value="{{ $v->address_id }}"  onclick='dodel(this.value)' title="删除">删除</button>
	    </div>
	</div>
	<div class="b">
		<div id="address-detail-8543557" class="form-detail-area">
			<table border="0" cellpadding="0" cellspacing="0">
				<tbody>
				<tr>
					<th>收货人：</th>
				    <td>{{ $v->address_consignee }}</td>
				</tr>
				<tr>
					<th class="vat">收货地址：</th>
				    <td>{{ $v->address_province }} {{ $v->address_city }} {{ $v->address_county }} {{ $v->address_detail }}</td>
				</tr>
				<tr>
					<th>联系号码：</th>
				    <td>{{ $v->address_consignee_phone }}</td>
				</tr>
				</tbody>
			</table>
		</div>
	</div>
	@endforeach{{ $list->links() }}  <!-- <span id='page' style='float:right;width:50px;padding:8px;border:1px solid #eee;border-radius:5px;box-shadow:0 5px 12px #eee'>当前页：</span> -->
	</div>
	</volist>
</div>

<!--我的收货地址-添加新地址 -->
<div class="myAddress-add-area">
	<div class="h" id='a'><b><strong>+ </strong>添加新地址</b></div>
    <div class="b" id='t' style="display:none">
    <script>
    	$('#a').mouseover(function(){
    		$('#a').css('cursor','pointer');
    	});
    </script>
    	<div class="form-edit-area">
	    <form id="myAddress-add-form" action="{{ url('/home/addAddress') }}" autocomplete="off" method="post" onsubmit="return ec.member.myAddress.save(this)" data-type="add">
		{{ csrf_field() }}
            <div class="form-edit-table">
                    <table border="0" cellpadding="0" cellspacing="0">
                        <tbody><tr>
                            <th><span class="required">*</span>收货人：</th>
                            <td><input maxlength="20" type="text" name="address_consignee" required class="text vam span-400" validator="validator11409811718553"></td>
                        </tr>
                        <tr>
                            <th rowspan="2" class="vat"><span class="required">*</span>收货地址：</th>
                            <td>
								<div id="myAddress-add-region" style="height:25px; float:left;">
								 <select required name="address_province" id="s_province"></select>
	 	                         <select required name="address_city" id="s_city"></select>
	 	                         <select required name="address_county" id="s_county"></select>
								 <script src="{{ asset('Home/Js/area.js') }}"/></script>
								 <script src="{{ asset('Home/Jquery/jquery-1.7.2.js') }}"/></script>
								</div>
								<span id="region-msg" style="float:left"></span>
							</td>
                        </tr>
                        <tr>
                            <td>
                           
							
							<input maxlength="100" type="text" class="text vam span-400" required name="address_detail" validator="validator21409811718554" id="input_label_0" style="z-index: 1;margin:3px 0 0 5px;" placeholder="详细收货地址"></td>
                        </tr>
                        <tr>
                            <th><span class="required">*</span>手机号码：</th>
                            <td>
				<div class="inline-block vam">
				
				       <input maxlength="15" id='ph' type="text" required name="address_consignee_phone" class="text vam span-150 ime-disabled" alt="phone-msg" validator="validator41409811718554">&nbsp;&nbsp;</div>
					   
			
				<div class="inline-block vam" id="phone-msg"></div>
			    </td><td id='ps'></td>
                        </tr>
                        <tr>
                            <th>&nbsp;</th>
                            <td><input type="checkbox" class="checkbox vam" name="address_default" value="1" id="myAddress-default"><label class="vam" for="myAddress-default">设为默认地址</label></td>
                        </tr>
                        <input type="hidden" name="randomFlag" required value="afc754d880d6b5786012c28eeb3d058f">
                    </tbody></table>
            </div>
            <div class="form-edit-action"><input type="submit" id='ok' class="button-action-ok-2 vam" value="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" class="button-action-cancel-2 vam" value="" onclick="ec.member.myAddress.reset()"></div>
	    </form>
        </div>
    </div>
</div>
<div class="hr-60"></div>

<script>
	$('li').click(function(){
		// var index = $('li').val();
		// console.log(index);
		$(this).stop(true,false).animate({"opacity":"0.4"},300).eq(index).stop(true,false).animate({"opacity":"1"},300);;
	});
	 
	// $(function(){
	// 		$("li").on("click",  function () {
	// 	// alert($(this).text());
	// 	// $('#page').html($(this).text())
	// 		$('#page').toggleClass('mytest');
	// 	});
	// })

	// $("li").on("mouseup",  function () {
	// 	// alert($(this).text());
	// 	$('#page').html($(this).text())
	// });

	$('#ph').keyup(function(){
		var ph = $(this).val();
		// alert(ph);
		if(/^((\d{11})|^((\d{7,8})|(\d{4}|\d{3})-(\d{7,8})|(\d{4}|\d{3})-(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1})|(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1}))$)$/.test(ph)){
			$('#phone-msg').html('');
		}else{
			$('#phone-msg').html('手机格式不正确');
			make = 0;
		}
	});

    $('#a').click(function(){
    	$('#t').toggle(1900);

    });

  	setInterval(function() {
  		$("#content").load(location.href+" #content>*","");
	}, 2000);

        function dodel(obj){
        	// var aid = obj.attr('value');
        	// alert(obj);
        	if(confirm('确定删除吗？')){
        		$.ajax({
		    		url:'/home/deladd',
		    		async:true,
		    		type:'GET',
		    		data:{
		    			'aid':obj,
		    		},
		    		dataType:'json',
		    		success:function(responseText,status,xhr)
		    		{
		    			console.log(responseText);
		    			if(responseText == 1){
		    				// window.location.onload();
		    				alert('删除成功');
		    			}else{
		    				alert('删除失败');
		    			}
		    		},
		    		error:function(){
		    			alert('删除失败');
		    		}
		    	});
	    	}
        }
     
        // 设置默认地址
       function dodef(obj){
        	// var aid = obj.attr('value');
        	 $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        	$.ajax({
        		url:'/home/defadd',
        		async:true,
        		type:'POST',
        		data:{
        			'aid':obj,
        		},
        		dataType:'json',
        		success:function(responseText,status,xhr)
	    		{
	    			console.log(responseText);
	    			if(responseText == 1){
	    				// window.location.onload();
	    				// setTimeout("Autofresh()",2000);
	    				alert('设置成功');
	    			}else{
	    				alert('失败');
	    			}
	    		},
	    		error:function(){
	    			alert('失败');
	    		}
        	});
        }	
    	
</script>
</div>
@endsection	