@extends('Admin.base.parent')
@section('content')
	<!-- Text Input -->
    <div class="block-area" id="text-input">
        <h3 class="block-title">修改用户</h3>
        
        <p>填空修改用户</p>
        
        <div class="row">
            <form action='/admin/demo4/{{ $ob->user_id }}' method='post'>
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="col-lg-12">
                    <input type="text" class="form-control m-b-10" placeholder="请输入用户名" name='user_username' value="{{ $ob->user_username }}">
                </div>
                
                <div class="col-lg-12">
                    <input type="text" class="form-control m-b-10" placeholder="请输入邮编" name='user_code' value="{{ $ob->user_code }}">
                </div>
                <div class="col-lg-12">
                    <select class="form-control m-b-10" name='user_sex'>
                        <option value='1' @if($ob->user_sex ==1)selected @endif>男</option>
                        <option value='2' @if($ob->user_sex ==2)selected @endif>女</option>
                    </select>
                </div>
                <div class="col-lg-12">
                    <input type="text" class="form-control m-b-10" disabled="" name='user_time' value="注册时间：{{ date('Y-m-d H:i:s',$ob->user_time) }}">
                </div>
                <div class="col-lg-12">
                    <input type='submit' class="btn btn-block btn-alt" value='提交'>
                </div>
            </form>
        </div>
        <p></p>
        
    </div>
@endsection