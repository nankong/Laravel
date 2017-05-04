<!DOCTYPE html>
<html>
<head>
<meta  charset="utf-8" />
<title>订单创建成功_华为商城</title>
<link rel="shortcut icon" href="{{ asset('Home/Ico/favicon.ico') }}"/>
<link href="{{ asset('Home/Css/cart.ec.core.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('Home/Css/cart.main.css') }}" rel="stylesheet" type="text/css">
<script type="text/javascript" src="{{ asset('Home/Jquery/jquery-1.7.2.js') }}"></script>
<!--[if lt IE 9]> <![endif]-->
</head>
<body>
<!-- 捷径栏粉红条部分 -->
@include('Home.base.pinkheader')
<!--头部 -->
<div class="order-header">
    <div class="g">
        <div class="fl">
            <div class="logo"><a href=""><img src="{{ asset('Home/images/newLogo.png') }}" /></a></div>
        </div>
        <div class="fr">
            <!--步骤条-三步骤 -->
            <div class="progress-area progress-area-3">
                <!--我的购物车 -->
                <div id="progress-cart" class="progress-sc-area hide">我的购物车</div>
                <!--核对订单 -->
                <div id="progress-confirm" class="progress-co-area hide">填写核对订单信息</div>
                <!--成功提交订单 -->
                <div id="progress-submit" class="progress-sso-area hide" style="display:block;">成功提交订单</div>
            </div>
        </div>
    </div>
</div>

<form action="" id="pay-go-form" method="post" target="_blank" class="hide">
    <input type="hidden" name="orderCode" value="1070054253">
    <input type="hidden" name="paymentMethod" id="order-paymentMethod" value="">    
    <input type="hidden" name="paymentType" id="order-paymentType" value="">
    <input type="hidden" name="state" value="1">
</form>
<div class="layout">
    
    <div class="hr-15"></div>
    <!--订单-表单-支付方式-20121012 -->
<!--订单-表单-支付方式-20121012 -->
<div class="order-payment" id="order-payment-mod">
    <h3 class="title">选择支付方式</h3>
    <div class="order-payment-list" id="order-payment-list">
        <dl>
        <dd>
            <div class="order-payment-area">
                <div class="h"><b>账户余额支付：</b></div>
                <div class="b clearfix" id="payment-bank-list-shortcut">
                    <ul>
                        <li>
                            <div class="payment-area">
                                <input id="input-CMB-5" class="radio vam" type="radio" seed="payment_1_1" data-type="5" name="bankName-input" value="CMB" checked>
                                <label class="vam" for="input-CMB-5">
                                    账户余额:
                                    <b style="color:red">&yen;<span>{{ $user_money }}</span></b>
                                </label>
                            </div>
                        </li>
                        
                    </ul>
                </div>
            </div>
            <div class="order-payment-area">
                <div class="h"><b>银行网银：</b>支持以下各银行储蓄卡及信用卡，<a href="javascript:return false;"title="查看支付限额" target="_blank">查看支付限额</a></div>
                <div class="b clearfix" id="payment-bank-list-bank">
                    <ul>
                        <li>
                            <div class="payment-area">
                                <input id="input-ABC-1" class="radio vam" type="radio" seed="payment_1_1" data-type="1" name="bankName-input" value="ABC">
                            <label class="vam" for="input-ABC-1">
                                <img class="vam pointer" src="{{ asset('Home/images/ABC_OUT.gif') }}" alt="中国农业银行" title="中国农业银行" disabled="">
                            <div class="bank-tips">
                                <p>储蓄卡单笔最高限额10000.00元，信用卡单笔最高限额5000.00元</p>
                            <s></s>
                            </div>
                        </li>
                        <li>
                            <div class="payment-area">
                                <input id="input-BJRCB-1" class="radio vam" type="radio" seed="payment_1_8" data-type="1" name="bankName-input" value="BJRCB">
                            <label class="vam" for="input-BJRCB-1">
                                <img class="vam pointer" src="{{ asset('Home/images/BJRCB_OUT.gif') }}" alt="北京农商银行" title="北京农商银行" disabled="">
                            <div class="bank-tips">
                                <p>储蓄卡单笔最高限额10000.00元，信用卡单笔最高限额5000.00元</p>
                            <s></s>
                            </div>
                        </li>
                        <li>
                            <div class="payment-area">
                                <input id="input-BOCB2C-1" class="radio vam" type="radio" seed="payment_1_8" data-type="1" name="bankName-input" value="BOCB2C">
                            <label class="vam" for="input-BOCB2C-1">
                                <img class="vam pointer" src="{{ asset('Home/images/BOC_OUT.gif') }}" alt="中国银行" title="中国银行" disabled="">
                            <div class="bank-tips">
                                <p>储蓄卡单笔最高限额10000.00元，信用卡单笔最高限额5000.00元</p>
                            <s></s>
                            </div>
                        </li>
                        <li>
                            <div class="payment-area">
                                <input id="input-CCB-1" class="radio vam" type="radio" seed="payment_1_8" data-type="1" name="bankName-input" value="CCB">
                            <label class="vam" for="input-CCB-1">
                                <img class="vam pointer" src="{{ asset('Home/images/CCB_OUT.gif') }}" alt="中国建设银行" title="中国建设银行" disabled="">
                            <div class="bank-tips">
                                <p>储蓄卡单笔最高限额10000.00元，信用卡单笔最高限额5000.00元</p>
                            <s></s>
                            </div>
                        </li>
                        <li>
                            <div class="payment-area">
                                <input id="input-CEB-1" class="radio vam" type="radio" seed="payment_1_8" data-type="1" name="bankName-input" value="CEB">
                            <label class="vam" for="input-CEB-1">
                                <img class="vam pointer" src="{{ asset('Home/images/CEB_OUT.gif') }}" alt="中国光大银行" title="中国光大银行" disabled="">
                            <div class="bank-tips">
                                <p>储蓄卡单笔最高限额10000.00元，信用卡单笔最高限额5000.00元</p>
                            <s></s>
                            </div>
                        </li>
                        <li>
                            <div class="payment-area">
                                <input id="input-CIB-1" class="radio vam" type="radio" seed="payment_1_8" data-type="1" name="bankName-input" value="CIB">
                            <label class="vam" for="input-CIB-1">
                                <img class="vam pointer" src="{{ asset('Home/images/CIB_OUT.gif') }}" alt="兴业银行" title="兴业银行" disabled="">
                            <div class="bank-tips">
                                <p>储蓄卡单笔最高限额10000.00元，信用卡单笔最高限额5000.00元</p>
                            <s></s>
                            </div>
                        </li>
                        <li>
                            <div class="payment-area">
                                <input id="input-CITIC-1" class="radio vam" type="radio" seed="payment_1_8" data-type="1" name="bankName-input" value="CITIC">
                            <label class="vam" for="input-CITIC-1">
                                <img class="vam pointer" src="{{ asset('Home/images/CITIC_OUT.gif') }}" alt="中信银行" title="中信银行" disabled="">
                            <div class="bank-tips">
                                <p>储蓄卡单笔最高限额10000.00元，信用卡单笔最高限额5000.00元</p>
                            <s></s>
                            </div>
                        </li>
                        <li>
                            <div class="payment-area">
                                <input id="input-CMB-1" class="radio vam" type="radio" seed="payment_1_8" data-type="1" name="bankName-input" value="CMB">
                            <label class="vam" for="input-CMB-1">
                                <img class="vam pointer" src="{{ asset('Home/images/CMB_OUT.gif') }}" alt="招商银行" title="招商银行" disabled="">
                            <div class="bank-tips">
                                <p>储蓄卡单笔最高限额10000.00元，信用卡单笔最高限额5000.00元</p>
                            <s></s>
                            </div>
                        </li>
                        <li>
                            <div class="payment-area">
                                <input id="input-CMBC-1" class="radio vam" type="radio" seed="payment_1_8" data-type="1" name="bankName-input" value="CMBC">
                            <label class="vam" for="input-CMBC-1">
                                <img class="vam pointer" src="{{ asset('Home/images/CMBC_OUT.gif') }}" alt="中国民生银行" title="中国民生银行" disabled="">
                            <div class="bank-tips">
                                <p>储蓄卡单笔最高限额10000.00元，信用卡单笔最高限额5000.00元</p>
                            <s></s>
                            </div>
                        </li>
                        <li>
                            <div class="payment-area">
                                <input id="input-COMM-1" class="radio vam" type="radio" seed="payment_1_8" data-type="1" name="bankName-input" value="COMM">
                            <label class="vam" for="input-COMM-1">
                                <img class="vam pointer" src="{{ asset('Home/images/COMM_OUT.gif') }}" alt="交通银行" title="交通银行" disabled="">
                            <div class="bank-tips">
                                <p>储蓄卡单笔最高限额10000.00元，信用卡单笔最高限额5000.00元</p>
                            <s></s>
                            </div>
                        </li>
                        <li>
                            <div class="payment-area">
                                <input id="input-GDB-1" class="radio vam" type="radio" seed="payment_1_8" data-type="1" name="bankName-input" value="GDB">
                            <label class="vam" for="input-GDB-1">
                                <img class="vam pointer" src="{{ asset('Home/images/GDB_OUT.gif') }}" alt="广发银行" title="广发银行" disabled="">
                            <div class="bank-tips">
                                <p>储蓄卡单笔最高限额10000.00元，信用卡单笔最高限额5000.00元</p>
                            <s></s>
                            </div>
                        </li>
                        <li>
                            <div class="payment-area">
                                <input id="input-HZCB-1" class="radio vam" type="radio" seed="payment_1_8" data-type="1" name="bankName-input" value="HZCB">
                            <label class="vam" for="input-HZCB-1">
                                <img class="vam pointer" src="{{ asset('Home/images/HZCB_OUT.gif') }}" alt="杭州银行" title="杭州银行" disabled="">
                            <div class="bank-tips">
                                <p>储蓄卡单笔最高限额10000.00元，信用卡单笔最高限额5000.00元</p>
                            <s></s>
                            </div>
                        </li>
                        <li>
                            <div class="payment-area">
                                <input id="input-ICBC-1" class="radio vam" type="radio" seed="payment_1_8" data-type="1" name="bankName-input" value="ICBC">
                            <label class="vam" for="input-ICBC-1">
                                <img class="vam pointer" src="{{ asset('Home/images/ICBC_OUT.gif') }}" alt="中国工商银行" title="中国工商银行" disabled="">
                            <div class="bank-tips">
                                <p>储蓄卡单笔最高限额10000.00元，信用卡单笔最高限额5000.00元</p>
                            <s></s>
                            </div>
                        </li>
                        <li>
                            <div class="payment-area">
                                <input id="input-PSBC-1" class="radio vam" type="radio" seed="payment_1_8" data-type="1" name="bankName-input" value="PSBC">
                            <label class="vam" for="input-PSBC-1">
                                <img class="vam pointer" src="{{ asset('Home/images/PSBC_OUT.gif') }}" alt="中国邮政储蓄银行" title="中国邮政储蓄银行" disabled="">
                            <div class="bank-tips">
                                <p>储蓄卡单笔最高限额10000.00元，信用卡单笔最高限额5000.00元</p>
                            <s></s>
                            </div>
                        </li>
                        <li>
                            <div class="payment-area">
                                <input id="input-SPDB-1" class="radio vam" type="radio" seed="payment_1_8" data-type="1" name="bankName-input" value="SPDB">
                            <label class="vam" for="input-SPDB-1">
                                <img class="vam pointer" src="{{ asset('Home/images/SPDB_OUT.gif') }}" alt="上海浦东银行" title="上海浦东银行" disabled="">
                            <div class="bank-tips">
                                <p>储蓄卡单笔最高限额10000.00元，信用卡单笔最高限额5000.00元</p>
                            <s></s>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="order-payment-area">
                
            </div>  
        </dd>
        </dl>
        <div class="order-payment-action-area"><a class="button-sytle-5">确认支付</a></div>
    </div>
    <!--订单-表单-支付方式列表结束 -->
</div>
</div> 
@include('Home.base.footer')
<!--底部 -->

</body>
</html>
<script type="text/javascript">
    $(".button-sytle-5").click(function(){
        // alert(1111);
        if({{ $leftmoney }}<0){
            alert("余额不足");
        }else{
            $(".button-sytle-5").attr("href","/home/cart/dosubmit/{{ $id }}");
        }
    });
</script>
