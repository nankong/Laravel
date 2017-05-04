@extends('Admin.base.parent')
@section('content')
	<!-- Text Input -->
    <div class="block-area" id="text-input">
        <h3 class="block-title">修改管理名</h3>
        
        <p>填空修改名</p>
        
        <div class="row">
            <form action='/admin/SuperAdmin/{{ $ob->admin_id }}' method='post'>
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="col-lg-12">
                    <input type="text" class="form-control m-b-10" placeholder="请输入管理名" name='admin_name' value="{{ $ob->admin_name }}">
                </div>
                
                <div class="col-lg-12">
                    <input type="text" class="form-control m-b-10" placeholder="请输入密码" name='admin_pass' value="{{ $ob->admin_pass }}">
                </div>
                <div class="col-lg-12">
                    <select class="form-control m-b-10" name='admin_pw'>
                        <option value='1' @if($ob->admin_pw ==1)selected @endif>开</option>
                        <option value='2' @if($ob->admin_pw ==2)selected @endif>关</option>
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