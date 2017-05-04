@extends('Admin.base.parent')
@section('content')
	<!-- Text Input -->
    <div class="block-area" id="text-input">
        <h3 class="block-title">修改订单</h3>
        
        <p>填空修改用户</p>
        
        <div class="row">
            <form action='{{ url("/admin/order") }}/{{ $ob->order_od_numb }}' method='post'>
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <!-- 'order_nid','order_state','order_time' -->
                <div class="col-lg-4">
                    <div class="form-control m-b-10" name='order_od_numb'>{{ $ob->order_od_numb }}</div>
                </div>
                <div class="col-lg-4">
                    <input type="text" class="form-control m-b-10" name='order_detail' value="{{ $ob->order_detail }}">
                </div>
                <div class="col-lg-4">
                    <select name='order_state' class="form-control m-b-10">
                        <option value="0" @if($ob->order_state == 0) selected @endif>待付款</option>
                        <option value="1" @if($ob->order_state == 1) selected @endif>已付款</option>
                        <option value="2" @if($ob->order_state == 2) selected @endif>待发货</option>
                        <option value="3" @if($ob->order_state == 3) selected @endif>已发货</option>
                        <option value="4" @if($ob->order_state == 4) selected @endif>待收货</option>
                        <option value="4" @if($ob->order_state == 5) selected @endif>已收货</option>
                        <option value="4" @if($ob->order_state == 6) selected @endif>已评价</option>
                        <option value="4" @if($ob->order_state == 7) selected @endif>交易成功</option>
                    </select>
                </div>
                <div class="col-lg-4">
                    <input type="text" class="form-control m-b-10" name="order_name" value="{{ $ob->order_name }}">
                </div>
                <div class="col-lg-4">
                    <div class="form-control m-b-10" name="order_time">{{ date('Y-m-d H:i:s',$ob->order_time) }}</div>
                </div>
                <div class="col-lg-12">
                    <input type='submit' class="btn btn-block btn-alt" value='修改'>
                </div>
            </form>
        </div>
        <p></p>
        
    </div>
@endsection