@extends('Home.base.parent')
@section('title')
	<title>首页_个人中心_华为商城</title>
@endsection
@section('content')
<div class="hr-10"></div>
<div class="g">
	<!--面包屑 -->
	<div class="breadcrumb-area icon-breadcrumb fcn">您现在的位置：
		<a href="{{ url('/') }}" title="首页">首页</a>&nbsp;&gt;&nbsp;
		<span><b>个人中心</b></span>
		<span id="pathPoint"></span>
		<b id="pathTitle"></b>
	</div>
</div>
<div class="hr-15"></div>

<div class="g">
    <div class="fr u-4-5"><!--个人中心 -->
<div class="ic-area">
	<div class="ic-detail-area">
		<div class="h">
			<h3><b>
				{{ $list->user_username }}
				</b>
				<em class="vip-state">
					<a href="javascript:void(0)" title="VMALL 会员"><i class="icon-vip-level-5">
					</i></a>
				
				</em>
				<b>欢迎您！</b>
			</h3>
			<div class="ic-detail-area">
				<table border="0" cellpadding="0" cellspacing="0">
					<tbody>
						<tr>
							<th>我的经验值：</th>
							<td>
									<a href="javascript:void(0);" class="red"><b>{{ $list->user_balance }}</b></a>
						</td>
						</tr>
						<tr>
							<th>我的特权：</th>
							<td>
								<div class="ic-user-privilege">
						    			<a href="javascript:void(0);" title="“V”字身份标识：获得与Vmall会员等级对应的“V”身份标识"><img src="{{ asset('Home/images/icon_privilege_vip_large_light.png') }}"  alt="“V”字身份高亮显示"></a>
						    			<a href="{javascript:void(0)}" title="会员日活动参与权：有权参与专属的会员日活动"><img src="{{ asset('Home/images/icon_privilege_vipDay_large_gray.png') }}"  alt="会员日活动参与权"></a>
									
								</div></td>
						</tr>
					
					</tbody>
				</table>
			</div>
		</div>
		<div class="b">
			<div class="form-detail-area">
				<table border="0" cellpadding="0" cellspacing="0">
					<tbody>
						<tr>
							<th style=" width:100px;">订单中心:</th>
							<td>
								<a href="{{ url('/home/order') }}">处理中的订单（<b id="member-unpayCount"></b>）</a>
								<a id="member_index_notRemarkCount" href="{{ url('/home/comment') }}">待评价的商品（<b id="member-notRemarkCount"></b>）</a>
							</td>
						</tr>
						
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="hr-70"></div>
	
</div>
</div>
@endsection    	
