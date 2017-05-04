@extends('Admin.base.parent')
@section('content')
    <!-- Text Input -->
    <div class="block-area" id="text-input">
        <h3 class="block-title">修改网站配置</h3>
        <p>修改配置</p>
        <div class="row">
            <form action='{{ url("/admin/config") }}/{{ $ob->config_id }}' method='post'>
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="col-lg-4">
                    <div>网站名称</div>
                    <input type="text" class="form-control m-b-10" name='config_title' value="{{ $ob->config_title }}">
                </div>
                <div class="col-lg-12">
                    <div>网站关键词</div>
                    <input type="text" class="form-control m-b-10" name='config_keys' value="{{ $ob->config_keys }}">
                </div>
                <div class="col-lg-12">
                    <div>网站介绍</div>
                    <input type="text" class="form-control m-b-10" name='config_desn' value="{{ $ob->config_desn }}">
                </div>
                <div class="col-lg-12">
                    <div>网站状态</div>
                    <input type="radio" name='config_state' value="0" @if($ob->config_state == 0) checked @endif>维护<br>
                    <input type="radio" name='config_state' value="1" @if($ob->config_state == 1) checked @endif>开启
                </div>
                <div class="col-lg-12">
                    <input type='submit' class="btn btn-block btn-alt" value='修改'>
                </div>
            </form>
        </div>
        <p></p>
        
    </div>
@endsection