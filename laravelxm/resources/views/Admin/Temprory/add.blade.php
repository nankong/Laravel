@extends('Admin.base.parent')
@section('content')
	<!-- Text Input -->
    <div class="block-area" id="text-input">
        <h3 class="block-title">添加购物</h3>
        @if(count($errors) > 0)
            <div class='alert alert-danger'>
                <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </ul>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-warning alert-icon">
            {{ session('error') }}
            <i class="icon"></i>
            </div>
        @endif
        <p>添加到购物车</p>
        
        <div class="row">
            <form action="{{ url('admin/temprory') }}" method='post'>
                {{ csrf_field() }}
                <div class="col-lg-4">
                    <input type="hidden" name="temprory_pic">
                    <input type="text" class="form-control m-b-10" placeholder="请输入商品id" name='temprory_gid'>
                </div>
                <div class="col-lg-4">
                    <input type="text" class="form-control m-b-10" placeholder="请输入商品数量" name='temprory_num'>
                </div>
                <div class="col-lg-4">
                    <input type="text" class="form-control m-b-10" placeholder="请输入商品价格" name='temprory_price'>
                </div>
                <div class="col-lg-12">
                    <input type='submit' class="btn btn-block btn-alt" value='提交'>
                </div>
            </form>
        </div>
        <p></p>
        
    </div>
@endsection