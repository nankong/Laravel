@extends('Admin.base.parent')
@section('content')
	<!-- Text Input -->
    <div class="block-area" id="text-input">
        <h3 class="block-title">添加公告</h3>
        
        <p>填空添加公告</p>
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
            <form action='/admin/notice' method='post'>
                {{ csrf_field() }}
                <input type="hidden" name="notice_time" >
                <div class="col-lg-12">
                    <input type="text" class="form-control m-b-10" placeholder="请输入标题" name='notice_title'>
                </div>
                <div class="col-lg-12">
                    <input type="text" class="form-control m-b-10" placeholder="请输入内容" name='notice_content'>
                </div>
                <div class="col-lg-12">
                    <select class="form-control m-b-10" name='notice_type'>
                        <option>--请选择状态--</option>
                        <option value='1'>重要</option>
                        <option value='2'>不重要</option>
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