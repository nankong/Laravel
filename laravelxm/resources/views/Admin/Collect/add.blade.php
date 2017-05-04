@extends('Admin.base.parent')
@section('content')
	<!-- Text Input -->
    <div class="block-area" id="text-input">
        <h3 class="block-title">添加收藏</h3>
        @if(count($errors) > 0)
            <div class='alert alert-danger'>
                <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </ul>
            </div>
        @endif
        <p>添加收藏</p>
        
        <div class="row">
            <form action="{{ url('admin/collect') }}" method='post'>
                {{ csrf_field() }}
                <input type="hidden" class="form-control m-b-10" name='collect_time'>
                <div class="col-lg-4">
                    <input type="text" class="form-control m-b-10" placeholder="请输入商品id" name='collect_gid'>
                </div>
                <div class="col-lg-12">
                    <input type='submit' class="btn btn-block btn-alt" value='提交'>
                </div>
            </form>
        </div>
        <p></p>
        
    </div>
@endsection