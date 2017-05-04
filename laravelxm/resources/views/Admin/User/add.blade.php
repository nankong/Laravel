@extends('Admin.base.parent')
@section('content')
	<!-- Text Input -->
    <div class="block-area" id="text-input">
        <h3 class="block-title">添加用户</h3>
        
        <p>填空添加用户</p>
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <div class="row">
            <form action='/admin/demo4' method='post'>
                {{ csrf_field() }}
                <input type="hidden" class="form-control m-b-10" name='user_time'>
                <div class="col-lg-12">
                    <input type="text" class="form-control m-b-10" placeholder="请输入用户名" name='user_username'>
                </div>
                <div class="col-lg-12">
                    <input type="text" class="form-control m-b-10" placeholder="请输入密码" name='user_pass'>
                </div>
                <div class="col-lg-12">
                    <input type="text" class="form-control m-b-10" placeholder="请输入邮编" name='user_code'>
                </div>
                <div class="col-lg-12">
                    <select class="form-control m-b-10" name='user_sex'>
                        <option>--请选择--</option>
                        <option value='1'>男</option>
                        <option value='2'>女</option>
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