@extends('Admin.base.parent')
@section('content')
	<!-- Text Input -->
    <div class="block-area" id="text-input">
        <h3 class="block-title">添加友情链接</h3>
        @if(count($errors) > 0)
            <div class='alert alert-danger'>
                <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </ul>
            </div>
        @endif
        <p>添加友情链接</p>
        
        <div class="row">
            <form action="{{ url('admin/links') }}" method='post'>
                {{ csrf_field() }}
                <div class="col-lg-4">
                    <input type="text" class="form-control m-b-10" placeholder="请输入链接名称" name='links_name'>
                </div>
                <div class="col-lg-4">
                    <input type="text" class="form-control m-b-10" placeholder="请输入连接地址" name='links_url'>
                </div>
                <div class="col-lg-4">
                    <select class="form-control m-b-10" name='links_switch'>
                        <option>--请选择--</option>
                        <option value='1'>开</option>
                        <option value='2'>关</option>
                    </select>
                </div>
                <div class="col-lg-12">
                    <input type='submit' class="btn btn-block btn-alt" value='提交'>
                </div>
            </form>
        </div>
        <p></p>
        
    </div>
@endsection