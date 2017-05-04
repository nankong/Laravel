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
            <form action='/admin/SuperAdmin' method='post'>
                {{ csrf_field() }}
                
                <div class="col-lg-12">
                    <input type="text" class="form-control m-b-10" placeholder="请输入管理名" name='admin_name'>
                </div>
                <div class="col-lg-12">
                    <input type="text" class="form-control m-b-10" placeholder="请输入密码" name='admin_pass'>
                </div>
                <div class="col-lg-12">
                    <select class="form-control m-b-10" name='admin_pw'>
                        <option>--请选择权限--</option>
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