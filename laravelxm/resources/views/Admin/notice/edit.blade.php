@extends('Admin.base.parent')
@section('content')
	<!-- Text Input -->
    <div class="block-area" id="text-input">
        <h3 class="block-title">修改公告</h3>
        
        <p>填空公告</p>
        
        <div class="row">
            <form action='/admin/notice/{{ $ob->notice_id }}' method='post'>
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="col-lg-12">
                    <input type="text" class="form-control m-b-10" placeholder="请输入标题" name='notice_title' value="{{ $ob->notice_title }}">
                </div>
                
                <div class="col-lg-12">
                    <input type="text" class="form-control m-b-10" placeholder="请输入内容" name='notice_content' value="{{ $ob->notice_content }}">
                </div>
                <div class="col-lg-12">
                    <select class="form-control m-b-10" name='notice_type'>
                        <option value='1' @if($ob->notice_type ==1)selected @endif>重要</option>
                        <option value='2' @if($ob->notice_type ==2)selected @endif>不重要</option>
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