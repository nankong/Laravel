@extends('Home.base.parent')
@section('title')
<meta http-equiv="Content-Language" content="zh-cn">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>商品评价_个人中心_华为商城</title>
<style type="text/css">
#commodity-list-head .current{
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
#commodity-list-head .num{
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
#commodity-list-head .prev{
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

#commodity-list-head .next{
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
	<!--面包屑 -->
	<div class="breadcrumb-area icon-breadcrumb fcn">您现在的位置：
		<a href="{{ url('/') }}" title="首页">首页</a>&nbsp;&gt;&nbsp;
		<span id="personCenter"><a href="{{ url('home/member') }}" title="个人中心">个人中心</a></span>
		<span id="pathPoint">&nbsp;&gt;&nbsp;</span>
		<b id="pathTitle">商品评价</b>
	</div>
</div>
<div class="hr-15"></div>

<div class="g">
    <div class="fr u-4-5"><!--栏目 -->
<div class="part-area clearfix">
    <div class="fl">
        <h3 class="ce-title"><span>商品评价</span></h3>
    </div>
</div>
<div class="hr-2"></div>
<!--商品评价 -->
<div class="ce-list">
	<div class="myOrders-title-area">
        <div class="h clearfix">
            <div class="fl">
                <div class="h-tab">
                   
                </div>
            </div>
        </div>
        <div class="b">
            <table id="commodity-list-head" border="0" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <th class="tr-span-2">编号</th>
                        <th class="tr-span-5">商品名称</th>
                        <th class="tr-span-7">评价时间</th>
                        <th>评价</th>
                        <th class="tr-span-2">评价分数</th>
                    </tr>
                </thead>
				   <volist name="list" id="vo"> 
				   @foreach($list as $v)
				   <tr>
                        <th class="tr-span-2">{{ $v->comment_id }}</th>
                        <th class="tr-span-5">{{ $v->goods_name }}</th>
                        <th class="tr-span-7">{{ date('Y-m-d H:i:s', $v->comment_pubtime) }}</th>
                        <th>{{ $v->comment_body }}...</th>
                        <th class="tr-span-2">{{ $v->comment_classify }}</th>
                    </tr>
                    @endforeach
					</volist>
            </table>
            {{ $list->appends($where)->links() }}
        </div>
    </div>    
	<div style="display:block;" class="ce-area " id="commodity-list">
		<table border="0" cellpadding="0" cellspacing="0">
			<tbody>
			      
			</tbody>
		</table>
	</div>
	<!--空数据-商品评价 -->
	<div style="display: block;" id="commodity-list-empty" class="ce-empty-area"></div>
</div>
<div class="hr-25"></div>
<!--分页 -->
<div class="pager" id="list-pager"></div>
<input id="colid" value="0" type="hidden">
</div>
@endsection