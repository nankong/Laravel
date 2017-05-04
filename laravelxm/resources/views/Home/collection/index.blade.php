@extends('Home.base.parent1')
@section('title')
<meta name='csrf-token' content="{{ csrf_token() }}">
<title>用户收藏页</title>
<meta  name="keywords"  content=",">
<meta  name="description"  content="">

<link  rel="shortcut icon"  href="{{ asset('Home/Ico/favicon.ico') }}">
<link  href="{{ asset('Home/Css/ec.core.css') }}"  rel="stylesheet"  type="text/css">

<link  href="{{ asset('Home/Css/main.css') }}"  rel="stylesheet"  type="text/css">
<script  src="{{ asset('Home/Js/jsapi.js') }}"  namespace="ec"></script>
<script  src="{{ asset('Home/Js/jquery-1.4.4.min.js') }}"></script>
<script  src="{{ asset('Home/Js/ec.core.js') }}"></script> 
<script  src="{{ asset('Home/Js/ec.business.js') }}"></script> 
<script type="text/javascript" src="{{ asset('Home/Jquery/jquery-1.7.2.js') }}"></script>
<style>
#list-pager-2 .current{
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
#list-pager-2 .num{
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
#list-pager-2 .prev{
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

#list-pager-2 .next{
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
<script type="text/javascript" src="{{ asset('Home/Jquery/jquery-1.7.2.js')}}"></script>
</head>



@endsection
@section('bodycss')
<body class="wide detail">
@endsection
@section('content')
<div  class="hr-15"></div>
<div  class="g">
    <div  class="fl u-3-4"> 
        <div  class="hr-10"></div>
        
        <div  class="g-l g-l-none">
            
            <div  class="h">
                <div  id="ct-list"  class="fl">

		    <h2>收藏的商品</h2>
                    
					<div  class="h-tab">
                        
                    </div>
					
                </div>
                <div  class="fr">
                	
                		
                    
                </div>
            </div>
           
	    <span>
<script  src="{{ asset('Home/Js/list.js') }}"  style="display: none;"></script><script  id="jsapi_loader0"  loadtype="insert"  type="text/javascript"  src="{{ asset('Home/Js/jquery.form-2.49.js') }}"  charset="utf-8"  style="display: none;"></script><script  style="display: none;">(function(){var time = 0,el = document.getElementById('jsapi_loader0');if(!el || (el.readyState && 'complete' != el.readyState)){ if(time<10){ setTimeout(arguments.callee,30); time++; }else{ logger.error('load the script of id jsapi_loader0 fail!');} return; }ol._setLoadStatus("jquery.form","complete");})();</script><script  id="jsapi_loader1"  loadtype="insert"  type="text/javascript"  src="{{ asset('Home/Js/ajax.js') }}"  charset="utf-8"  style="display: none;"></script><script  style="display: none;">(function(){var time = 0,el = document.getElementById('jsapi_loader1');if(!el || (el.readyState && 'complete' != el.readyState)){ if(time<10){ setTimeout(arguments.callee,30); time++; }else{ logger.error('load the script of id jsapi_loader1 fail!');} return; }ol._setLoadStatus("ajax","complete");})();</script>
<script  style="display: none;">
ec.load("ec.pager");
</script><script  id="jsapi_loader2"  loadtype="insert"  type="text/javascript"  src="{{ asset('Home/Js/pager-min.js') }}"  charset="gbk"  style="display: none;"></script><script  style="display: none;">(function(){var time = 0,el = document.getElementById('jsapi_loader2');if(!el || (el.readyState && 'complete' != el.readyState)){ if(time<10){ setTimeout(arguments.callee,30); time++; }else{ logger.error('load the script of id jsapi_loader2 fail!');} return; }ol._setLoadStatus("ec.pager/pager-min.js","complete");})();</script>
<div  id="category-2"  class="b">

<div  class="pro-list">
<ul  id="category-2-list">


<!-------------一个商品分类方式-------------->
<volist name="list_goods" id="vo">
			@foreach( $list as $v)
			<li>
			
			<div style="float:left;">
				 
				 <p  class="p-img">
				  <a  href="/home/goodinfo/{{ $v->goods_id}}"  title="{$vo.goods_keywords}"  target="_blank">
				  <img  alt="{$vo.goods_keywords}"  
				  src="{{ asset('admin/upload') }}/{{ $v->goods_big_pic }}"></a>
				</p>
				<p  class="p-price"><b>¥{{ $v->goods_sale_price }}</b></p>
				<p  class="p-name">
				<a  href="/home/goodinfo/{{ $v->goods_id}}"  title="{$vo.goods_keywords}"  target="_blank">{{ $v->goods_name }}<span  class="red"></span></a><br><a  href="/home/collect/del/{{ $v->goods_id}}"  title="{$vo.goods_keywords}"  target="_blank">删除<span  class="red"></span></a></p>
				   @if( $v->goods_state == 'hot')
				   	  <i><img  src="{{ asset('Home/Images/1382542488099.png') }}"  style=""></i>
				   @elseif( $v->goods_state == 'new')
				      <i><img  src="{{ asset('Home/Images/1382542518162.png') }}"  style=""></i>
				   @elseif( $v->goods_state == 'max')
				      <i><img  src="{{ asset('Home/Images/1382542555129.png') }}"  style=""></i>
				   @elseif( $v->goods_state == 'first')    
				      <i><img  src="{{ asset('Home/Images/1382593860805.png') }}"  style=""></i>
				   @else
				   	  <li></li>
				   @endif  
				   <!-- <if condition="$vo['goods_state'] eq '热卖'">
				     <i><img  src="__PUBLIC__/Images/1382542488099.png"  style=""></i>
				   <elseif condition="$vo['goods_state'] eq '新品'"/>
					   <i><img  src="__PUBLIC__/Images/1382542518162.png"  style=""></i>
				   <elseif condition="$vo['goods_state'] eq '人气'"/>
				     <i><img  src="__PUBLIC__/Images/1382542555129.png"  style=""></i>
				   <elseif condition="$vo['goods_state'] eq '首发'"/>
				     <i><img  src="__PUBLIC__/Images/1382593860805.png"  style=""></i>  
					 
			       <else/>
					 <i></i>
				  </if> -->
			</div>
			
			</li>
			@endforeach
</volist>
<!-------------一个商品分类方式-------->








</ul>
</div>
<div  class="hr-25"></div>

     <div  id="list-pager-2"  class="pager">
	  <!-- 分页 -->
	   
		     
			 
		   
		
     </div>
</div>

    </span>
        </div>
    </div>
    <div  class="fr u-1-4">
<div  class="hot-area">
	<div  class="h">
		<h3><span>热销榜单</span></h3>
	</div>
	<div  class="b">
	     
		
		 


<div  class="pro-list" id="pro-list">
		<ul>
		    
			
			
		</ul>		
</div>
     <script type="text/javascript">
	     //ajax的形式加载
		 
		 $(function(){
		     $.ajax({
			      url:"/home/hotsale",
				  type:'GET',
				  dataType:'json',
				  success:function(responseText,status,xhr){
				       if(status=='success'){
					      if(responseText['status']==1){
						       // console.log(responseText);
						       var Str=responseText.content.toString();
							   
						       $(Str).appendTo($("#pro-list ul"));
							 
						  
						  }else{
						     
						  }
					      
					   
					   }
				  
				  }
				  
                 				 
				 
			 
			 
			 
			 
			 
			 
			 
			 });
		 
		 
		 
		 
		 
		 
		 });
		 
		 
		 
	 
	 
	 
	 
	 
	 
	 </script>
	</div>
</div>
        <div  class="hr-15"></div>

<div  id="product-history-area"  class="rl-area hide"  style="display: block;">
         <!-----------------引入了商品浏览部分---------->
		 <include file="Public/scangoods" />
    </div>
</div>   

   </div>
</div>
<div  class="hr-40"></div>
@endsection
