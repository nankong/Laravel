<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta name='csrf-token' content="{{ csrf_token() }}"> 
<title>购物车_华为商城</title>
<link rel="shortcut icon" href="{{ asset('Home/Ico/favicon.ico') }}"/>
<link href="{{ asset('Home/Css/cart.ec.core.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('Home/Css/cart.main.css') }}"  rel="stylesheet" type="text/css">
<script type="text/javascript" src="{{ asset('Home/Jquery/jquery-1.7.2.js') }}"></script>
</head>
<body>
<!-- 捷径栏 -->
@include('Home.base.pinkheader')
<!--头部 -->
<div class="order-header">
    <div class="g">
        <div class="fl">
            <div class="logo"><a href="{{ url('/') }}"><img src="{{ asset('Home/images/newLogo.png') }}" /></a></div>
        </div>
        <div class="fr">
            <!--步骤条-三步骤 -->
            <div class="progress-area progress-area-3">
                <!--我的购物车 -->
                <div id="progress-cart" class="progress-sc-area hide" style="display:block;">我的购物车</div>
                <!--核对订单 -->
                <div id="progress-confirm" class="progress-co-area hide" >填写核对订单信息</div>
                <!--成功提交订单 -->
                <div id="progress-submit" class="progress-sso-area hide">成功提交订单</div>
            </div>
        </div>
    </div>
</div>
<div class="layout">
    <!-- 20131223-购物车-start -->
    <div class="sc-list">
        <!-- 20131223-购物车-商品列表-start -->
        <div class="sc-pro-list">
            <!-- 20131223-订单-商品-标题-start -->
            <div class="sc-pro-title-area">
                <div class="h">
                    <table border="0" cellpadding="0" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="tr-check">
                                    
                                </th>
                                <th class="tr-pro">商品</th>
                                <th class="tr-price">单价<em>（元）</em></th>
                                <th class="tr-quantity">数量</th>
                                <th class="tr-subtotal">小计<em>（元）</em></th>
                                <th class="tr-operate">操作</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <!-- 20131223-订单-商品-标题-end -->

        <form id="cart-form" autocomplete="off" onsubmit="return false;" >
            
            <span id="cart-list"><!--product-list start-->
              
                <div class="sc-pro-area selected" id="order-pro-1989">
                    <table border="0" cellpadding="0" cellspacing="0">
                        
                        <!--这是一个商品的信息-->
                        
                        <!--这是一个商品的信息-->
                    
                    </table>
                </div><!--product-list end-->
                
<script type="text/javascript">
    $(function(){
        doCar();
        //ajax的形式获取购物车中的数据
        function doCar(){
            var url="/home/cart/none";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:"/home/cart/cartContent",
                type:'post',
                dataType:'json',
                success:function(responseText,status,xhr){
                    if(status=="success"){
                        if(responseText.cat_status==1){
                            $("#order-pro-1989").find('table').html(responseText.content.str);
                            $("#sc-cartInfo-totalOriginalPrice").find('span').html(responseText.content.car_total_money.toFixed(2));
                            $("#sc-cartInfo-minusPrice").find('span').html(responseText.content.car_sale_money.toFixed(2));
                            $("#sc-cartInfo-totalPrice").find('span').html(responseText.content.car_end_money.toFixed(2));
                            if(responseText.content.car_end_money < 200){
                                $(".yunfei").html('15');
                            }
                        }else{
                       window.location.href=url;
                        }
                    }else{
                       window.location.href=url;
                    }
                    console.log(responseText);
                },
                error:function(){
                   alert('加载cartContent失败,请重试');
                },
                timeout:60*1000,
            });

     }
  });


</script>


<script type="text/javascript">
      $(function(){
           //+
           
            $("#order-pro-1989").on("click",'.icon-minus-3',function(){
                 var goods_id=$(this).closest('td').parent().find("#box-1989").val();
                  var input=$(this).next('input');
                 
                 input.val(function(i,v){
                    
                     return v<=1?1:--v;
                 
                 });
                  var value=input.val();
                  if(value>=0&&value<=10){
                  
                     doAjax(goods_id,value);
                  
                  }
            });
            
            
            $("#order-pro-1989").on("click",'.icon-plus-3',function(){
                 var goods_id=$(this).closest('td').parent().find("#box-1989").val();
                 var input=$(this).prev('input');
                
                 input.val(function(i,v){
                    
                     return v>9?10:++v;
                     
                 
                 });
                 
                 var value=input.val();
                 if(value>=0&&value<=10){
                      doAjax(goods_id,value);
                 }
            });
            
         function doAjax(goods_id,num){
                 $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                 });
                 $.ajax({
                      url:"/home/cart/changeGoodsNum",
                      type:"POST",
                      data:{
                          'goods_id':goods_id,
                          'goods_num':num
                      },
                      dataType:'json',
                      success: function(responseText,status,xhr){
                            if(status=="success"){
                                doCar();
                            }else{
                               alert("修改失败,请重试");
                            }
                            console.log(responseText);
                      },
                      error:function(){
                          alert("请求修改失败!,请重试");
                      },
                      timeout:60*1000,
                  });
         }
         

         function doCar(){
         var url="/home/cart/none";
         $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
         });
         $.ajax({
             url:"/home/cart/cartContent",
             type:'POST',
             dataType:'json',
             success:function(responseText,status,xhr){
                 if(status=="success"){
                     if(responseText.cat_status==1){
                         $("#order-pro-1989").find('table').html(responseText.content.str);
                         $("#sc-cartInfo-totalOriginalPrice").find('span').html(responseText.content.car_total_money.toFixed(2));
                         $("#sc-cartInfo-minusPrice").find('span').html(responseText.content.car_sale_money.toFixed(2));
                         $("#sc-cartInfo-totalPrice").find('span').html(responseText.content.car_end_money.toFixed(2));
                         if(responseText.content.car_end_money < 200){
                            $(".yunfei").html('15');
                         }
                     }else{
                       window.location.href=url;
                     }
                 }else{
                    window.location.href=url;
                 }
             },
             error:function(){
                alert('加载cartContent2失败,请重试');
             },
             timeout:60*1000,
         });
      }
            
      $("#order-pro-1989").on('click','.icon-sc-del',function(){
             var goods_id=$(this).closest('td').parent().find("#box-1989").val();
             var url="/home/cart/none";
             $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
             });
             $.ajax({
                 url:"/home/cart/carDel",
                 type:"POST",
                 data:{
                      'goods_id':goods_id,
                 },
                 dataType:'json',
                 success:function(responseText,status,xhr){
                     if(status=='success'){
                         if(responseText=='1'){
                              var trs=$(this).closest('td').parent().children('tr').size();
                              if(trs<1){
                                  doCar();
                              }
                         }else{
                             alert('删除失败!,请重试');
                         }
                     
                     }else{
                        alert('删除失败!,请重试');
                     }
                 
                 },
                 error:function(){
                      alert("请求删除失败,请重试");
                 },
                 timeout:60*1000,
             });
      });     
    
         //删除操作按钮点选    
         $("#checkAll-buttom").click(function(){
             $('input:checkbox').attr('checked',true);
         });
         $("#checkFan-buttom").click(function(){
            var list = $('input:checked');
            // 让所有的都选中
            $('.checkbox').attr('checked',true);
            //让之前选中的变成不选中
            list.attr('checked',false);
         });

         $("#cart-all-del").click(function(){
             var goods_select_ids=$(".checkbox:checked").size();
             var goods_ids="";
             if(goods_select_ids>0){
                 $(".checkbox:checked").each(function(i,v){
                     goods_ids+=","+$(this).val();
                 });
             //ajax执行删除操作
             var url="/home/cart/none";
             $.ajax({
                  url:"/home/cart/carDelNum",
                  type:"POST",
                  data:{
                      "goods_ids":goods_ids,
                  },
                  dataType:'json',
                  success:function(responseText,status,xhr){
                      if(status=="success"){
                         if(responseText==1){
                              doCar();
                             var trs=$("#order-pro-1989").find('table').find('tr').size();
                             if(trs>0){
                                
                             }else{
                                 window.location.href=url;
                             }
                         
                         }else{
                              alert("删除失败,请重试");
                         }
                      
                      
                      }else{
                         alert("删除失败!,请重试");
                      }
                  
                  },
                  error:function(){
                      alert("删除失败!,请重试");
                  },
                  timeout:60*1000,
             });
             
             }
         });
      });

</script>                     
                    
            </span>
        </form>
    </div>
    <div class="hr-20"></div>
        <!--购物车-商品列表 end -->

        <!-- 购物车列表 End-->
    </div>
    <div class="hr-25"></div>
    <div class="sc-total-area clearfix" id="cart-total-area">
        <div class="sc-total-control">
            <a class="vam" id="checkAll-buttom">全选</a>
            <a class="vam" id="checkFan-buttom">反选</a>
            <a seed="cart-all-del" href="javascript:void(0);" id="cart-all-del" class="vam" >删除选中商品</a>
        </div>
        <div class="sc-total-price">
            <table cellspacing="0" cellpadding="0" border="0">
                <tbody>
                    <tr>
                        <th>总计金额：</th>
                        <td id="sc-cartInfo-totalOriginalPrice">¥<span>00.00</span></td>
                    </tr>
                    <tr>
                        <th>共节省：</th>
                        <td id="sc-cartInfo-minusPrice">¥<span>00.00</span></td>
                    </tr>
                    <tr>
                        <th><em>合计(含运费<b id="sc-cartInfo-totalPrice yunfei" class="yunfei">0</b>元)：<em></em></em></th>
                        <td><b id="sc-cartInfo-totalPrice">¥<span>00.00</span><b></b></b></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="hr-25"></div>
    <div class="sc-action-area clearfix">
        <a class="button-style-4 button-go-shopping-3" href="{{ url('/') }}">继续购物</a>
        @if(empty($uid))
        <a class="button-style-1 button-go-checkout-2" href="{{ url('/home/login') }}" seed="cart-pay">提交订单</a>
        @else
        <a class="button-style-1 button-go-checkout-2" href="{{ $uid }}" seed="cart-pay">提交订单</a>
        @endif
        <div class="sc-action-tips hide" id="sc-action-tips"><div class="tips-style-1 tips-area"><i></i><div class="tips-text"><p id="tips-text-p">购物车中有库存不足商品，请处理后结算</p></div><s></s></div>
        </div>
    </div>
    
    <div class="hr-35"></div>

@include('Home.base.footer')

</body>
</html>
