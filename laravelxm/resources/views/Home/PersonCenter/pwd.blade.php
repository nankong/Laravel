@extends('Home.base.parent')
@section('title')
	<title>密码管理_个人中心_华为商城</title>
	<meta name='csrf-token' content="{{ csrf_token() }}"> 
@endsection
@section('content')
<div class="hr-10"></div>
<div class="g">
	<!--面包屑 -->
	<div class="breadcrumb-area icon-breadcrumb fcn">您现在的位置：
		<a href="{{ url('/') }}" title="首页">首页</a>&nbsp;&gt;&nbsp;
		<span id="personCenter"><a href="{{ url('home/member') }}" title="个人中心">个人中心</a></span>
		<span id="pathPoint">&nbsp;&gt;&nbsp;</span>
		<b id="pathTitle">密码管理</b>
	</div>
</div>
<div class="hr-15"></div>
<div class="g">
    <div class="fr u-4-5"><!--栏目 -->
	<div class="part-area clearfix">
		<div class="fl">
			<h3 class="password-title"><span>密码管理</span></h3>
		</div>
	</div>
	<div class="hr-35"></div>
	<!--密码管理 -->
	<form id="password-list"  onsubmit="return false;" >
		<div class="password-area">
			<div class="form-edit-area">
				<div class="form-edit-table">
					<table border="0" cellpadding="0" cellspacing="0">
						<tbody>
							<tr>
								<th><span class="required">*</span>当前密码：</th>
								<td>
								<input name="oldPassword" type="password" maxlength="16" class="text vam span-150"  id="input_label_0" style="z-index: 1;margin:3px 0 0 5px;" placeholder="请输入当前密码">
								</td>
							</tr>
							<tr>
								<th><span class="required">*</span>新密码：</th>
								<td>
								</label>
								
								<input name="newPassword" type="password" maxlength="16" class="text vam span-150"  id="input_label_1" style="z-index: 1;margin:3px 0 0 5px;" placeholder="请输入新密码">
								</td>
							</tr>
							<tr>
								<th><span class="required">*</span>重复新密码：</th>
								<td>
								
								<input name="renewPassword" type="password" maxlength="16" class="text vam span-150"  id="input_label_2" style="z-index: 1;margin:3px 0 0 5px;" placeholder="重复新密码">
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="form-edit-action">
					<input type="button" class="button-replace vam" id="pwd_submit" value="&nbsp;">
				</div>
			</div>
		</div>
	</form>
</div>
<script text='text/javascript'>
    $(function(){
	     var pwd_submit=$("#pwd_submit");
		 var url="{{ url('/home/login') }}";
		 pwd_submit.click(function(){
		     var status=1;
		     var old_pwd=$("#input_label_0").val();
			 var new_pwd=$("#input_label_1").val();
			 var align_pwd=$("#input_label_2").val();
			  
			 if(!(/^(\d|[a-z]){6,32}$/i.test(old_pwd))){
			     status=0;
				 alert("旧密码不符合要求格式");
				 return ;
			 }
			 if(new_pwd!=align_pwd){
			     alert("新密码两次不相等");
			     status=0;
				 return;
			 }
			 
		    if(!(/^(\d|[a-z]){6,32}$/i.test(new_pwd))){
			     status=0;
				 alert("新密码不符合要求格式");
				 return ;
			}			 
			if(status==1){	
				$.ajaxSetup({
	                headers: {
	                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	                }
	            });		  
			     $.ajax({
				     url:"/home/modpwd",
					 type:"POST",
					 dataType:'json',
					 data:{
					    'old_pwd':old_pwd,
						'new_pwd':new_pwd,
					 },
					 success:function(responseText,status,xhr){
					 	console.log(responseText);
					     if(status=="success"){
						     if(responseText==1){
							     alert("修改成功,请重新登录");
								 window.location.href=url;	 
							 }else if(responseText==2){
							     alert("当前密码不正确"); 
							 }else if(responseText==0){
							     alert("不得与当前密码一致"); 
							 }
						 }else{
						     alert("修改失败");
						 }
					 },
					 error:function(){
					     alert("修改失败！");
					 },
					 timeout:60*1000,
				 });
			} 
		 });
	});
</script>
@endsection