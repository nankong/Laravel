@extends('Home.base.parent')
@section('title')
    <title>首页_个人中心_账户余额</title>
    <style type="text/css">
    .inform-title-area .current{
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
    .inform-title-area .num{
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
    .inform-title-area .prev{
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

    .inform-title-area .next{
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
     #searchBar-area  #search_kw{
       
          height:30px;
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
		<b id="pathTitle">账户余额</b>
	</div>
</div>
<div class="hr-15"></div>

<div class="g">
    <div class="fr u-4-5"><!--栏目 -->
<div class="part-area clearfix">
    <div class="fl">
        <h3 class="balance-title"><span>账户余额</span></h3>
    </div>
</div>
<div class="hr-20"></div>
<!--账户余额 -->
<div class="balance-area">
	<div class="balance-have">您的余额:{{ $m->user_money }}元</div>
    <!--账户余额-消费明细列表 -->
    <dl>
    	<dt>消费明细列表</dt>
        <dd>
            <!--通知通告-消费明细列表 -->
            <div class="inform-title-area">
                <div class="b">
                    <table border="0" cellpadding="0" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="tr-span-4" style="width:220px;">购买时间</th>
                                <th class="tr-span-5">金额</th>
                                <th class="tr-span-4" style="width:400px;">详情</th>
                            </tr>
                        </thead>
						   <volist name="list" id="vo">
                            @if(count($list) >= 1)
                               @foreach($list as $v)
    						    <tr align="center">
                                    <td  style="height:34px">{{ date('Y-m-d H:i:s', $v->order_paytime) }}</td>
                                    <td  style="height:34px;">{{ $v->order_total }}</td>
                                    <td style="height:34px;">在线购买</td>
    						   </tr>
                               @endforeach 
                               </volist>
                        </table>
                    </div>
                </div>
                               @else
						   </volist>
                    </table>
                </div>
            </div>
            <div class="inform-empty-area  {$none_hide}">对不起，您暂时没有信息！</div>
                            @endif
            <div class="hr-20"></div>
        </dd>
    </dl>
</div>

<script src="{{ asset('Home/Js/balance.js') }}"></script></div>
@endsection