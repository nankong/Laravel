@extends('Admin.base.parent')
@section('content')
	<!-- Text Input -->
    <div class="block-area" id="text-input">
        <h3 class="block-title">修改连接</h3>
        
        <p>填空修改连接</p>
        
        <div class="row">
            <form action='{{ url("admin/links")."/".$ob->links_id }}' method='post'>
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="col-lg-4">
                    <input type="text" class="form-control m-b-10" placeholder="请输入连接名" name='links_name' value="{{ $ob->links_name }}">
                </div>
                <div class="col-lg-4">
                    <input type="text" class="form-control m-b-10" placeholder="请输入地址" name='links_url' value="{{ $ob->links_url }}">
                </div>
                <div class="col-lg-4">
                    <select class="form-control m-b-10" name='links_switch'>
                        <option value='1' @if($ob->links_switch ==1)selected @endif>开</option>
                        <option value='2' @if($ob->links_switch ==2)selected @endif>关</option>
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