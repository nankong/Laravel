@extends('Home.base.parent')
@section('title')
	<meta http-equiv="Content-Language" content="zh-cn">
	<meta name='csrf-token' content="{{ csrf_token() }}"> 
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<title>个人信息_个人中心_华为商城</title>
	<link rel="shortcut icon" href="#">
@endsection
@section('content')
<div class="hr-10"></div>
<div class="g">
	<!--面包屑 -->
	<div class="breadcrumb-area icon-breadcrumb fcn">您现在的位置：
		<a href="{{ url('/') }}" title="首页">首页</a>&nbsp;&gt;&nbsp;
		<span id="personCenter"><a href="{{ url('home/member') }}" title="个人中心">个人中心</a></span>
		<span id="pathPoint">&nbsp;&gt;&nbsp;</span>
		<b id="pathTitle">个人信息</b>
	</div>
</div>
<div class="hr-15"></div>
<div class="g">
    <div class="fr u-4-5"><!--栏目 -->
		<div class="part-area clearfix">
			<div class="fl">
				<h3 class="userInfo-title"><span>个人信息</span></h3>
			</div>
		</div>
		<div class="hr-20"></div>
		<!--个人信息 -->
		<div class="userInfo-area">
			<form id="personal-save" autocomplete="off" method="post" onsubmit="return return false;">
				<div class="userInfo-form-title">
					<b>基本信息</b>
					<span>（带<em>*</em>为必填项目）</span>
				</div>
				<div class="form-edit-area">
					<div class="form-edit-table">
						<table border="0" cellpadding="0" cellspacing="0" width="55%">
							<tbody>
								<tr>
									<th>用&nbsp;&nbsp;户&nbsp;&nbsp;名：</th>
									<td><span>{{ $list->user_username }}</span>
										
									</td>
								</tr>
								<tr>
									<th><span class="required">*</span>真实姓名：</th>
									<td><input maxlength="20" name="user_truename" id="true_name" type="text" class="text vam span-200" value="{{ $list->user_truename }}" ></td><span id='tn'></span>
								</tr>
								<tr>
									<th>邮&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;箱：</th>
									<td><input maxlength="20" name="user_uemail" type="text" class="text vam span-200" value="{{ $list->user_uemail }}"  id="user_email"></td><td id='em' ></td>
								</tr>
								
								<tr>
									<th><span class="required">*</span>性&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;别：</th>
									<td>
									  
										<input name="user_sex" id="man" type="radio" class="radio vam" value="1"  @if($list->user_sex == 1) checked @endif>
										<label for="man" class="vam">男</label>&nbsp;&nbsp;&nbsp;&nbsp;
										
										<input name="user_sex" id="woman" type="radio" class="radio vam" value="2" @if($list->user_sex == 2) checked @endif>
										 <label for="woman" class="vam">女</label>
									 	
									</td>
								</tr>
								<tr>
									<th>注册时间：</th>
									<td>{{ date('Y-m-d H:i:s', $list->user_time) }}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<!-- <div style="margin-left:50px;">
					<span class="required">*</span>密保问题：
					
						<select style="height:26px;" name="secure" id="secure_question">
						  <volist name="secure_info" id="vo">
						      <if condition="$vo.secure_id eq $user_info['secure_id']">
							    <option value="{$vo.secure_id}" selected>{$vo.secure_question}</option>
							   <else/>
							    <option value="{$vo.secure_id}">{$vo.secure_question}</option>
							  </if>
							</volist>
						</select><br/><br/>
						<span class="required">*</span>密保答案：<input type="text" id="secure_answer" value="{$user_info['user_answer']}" name="secure_answer" style="width:210px;height:22px;color:">
					
				</div> --><br/><br/>

				<div class="form-edit-action">
				     
					<input type="button" id="user_info_submit" class="button-action-save vam" value="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input class="button-action-cancel-2 vam" value=" " type="reset">
				</div>
				<input type="hidden" id="randomFlag" value="ed8df6720c0590632d7f2ed0425b171a">
			</form>
			<!-- 个人中心会员专享信息 -->
			<p><br></p>	
		</div>
	</div>
<script type="text/javascript">
// $('input[type=button]').addClass('disabled'); // Disables visually
// $('input[type=button]').prop('disabled', true); // Disables visually + functionally
// console.log($("#em").html());
 $("#user_email").keyup(function(){
    var em=$(this).val();
    if(/^([0-9A-Za-z\-_\.]+)@([0-9a-z]+\.[a-z]{2,3}(\.[a-z]{2})?)$/i.test(em)){
        $("#em").html('');
      	mark = 1;
    }else{
        $("#em").html("email不符合要求");  
        submit_status=0;mark=0;
    }   
});
 $(function(){
     var user_info_submit=$("#user_info_submit");//提交按钮
	
	  //单击按钮进行验证
     user_info_submit.click(function(){
             var submit_status=1;
		     var true_name=$("#true_name").val(); //真实姓名
			 var user_email=$("#user_email").val(); //用户的邮箱
			 // alert(user_email);
			 var user_sex=$("input:checked").val();//用户性别
			 // alert(user_sex);
			 // var secure_question=$("#secure_question").val();//密保问题的按钮
			 // var secure_answer=$("#secure_answer").val();//密保答案
             if(true_name.length<1){
			      alert("真实姓名不能为空!");
				  submit_status=0;
				  return ;
			 }
			 if(user_sex.length<1){
			      alert("性别不许为空!");
				  submit_status=0;
				  return ;
			 }
            //  if(secure_question<0){
			 //      alert("必须选择密保问题!");
				//   submit_status=0;
				//   return ; 
			 // }
			 
			 //  if(secure_answer.length<0){
			 //      alert("密保必须填写!");
				//   submit_status=0;
				//   return ; 
			 // }
			    //进行后台提交修改
			 if(submit_status==1&&mark==1){
			 	$.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                });
			     $.ajax({
				      url:"/home/modifierUser",
					  type:"POST",
					  dataType:'json',
					  data:{
					     'true_name': true_name,
						 'user_email':user_email,
						 'user_sex':user_sex,
						 // "secure_question":secure_question,
						 // "secure_answer":secure_answer,
					  },
					  success:function(responseText,status,xhr){
					      console.log(responseText);
					      if(status=='success'){
						       if(responseText==1){
							      alert("修改成功");
							   }else{
							      alert("修改失败");
							   }
						  }else{
						     alert("修改失败!");
						  }
					  
					  },
					  error:function(){
					     alert("修改失败!");
					     console.log(responseText);
					  },
					  timeout:60*1000,
				 });			 
			 } 
     });
 });
</script>
@endsection