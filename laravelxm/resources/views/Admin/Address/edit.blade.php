@extends('Admin.base.parent')
@section('content')
    <!-- Text Input -->
    <div class="block-area" id="text-input">
        <h3 class="block-title">修改收货地址</h3>
        
        <p>修改地址</p>
        
        <div class="row">
            <form action='{{ url("/admin/address") }}/{{ $ob->address_id }}' method='post'>
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <!-- 'order_nid','order_state','order_time' -->
                <div class="col-lg-4">
                    <div class="form-control m-b-10">{{ $ob->address_id }}</div>
                </div>
                <div class="col-lg-4">
                    <input type="text" class="form-control m-b-10" name='address_consignee' value="{{ $ob->address_consignee }}">
                </div>
                <div class="col-lg-4">
                    <input type="text" class="form-control m-b-10" name='address_detail' value="{{ $ob->address_detail }}">
                </div>
                <div class="col-lg-4">
                    <input type="text" class="form-control m-b-10" name='address_consignee_phone' value="{{ $ob->address_consignee_phone }}">
                </div>
                <div class="col-lg-12">
                    <input type='submit' class="btn btn-block btn-alt" value='修改'>
                </div>
            </form>
        </div>
        <p></p>
        
    </div>
@endsection