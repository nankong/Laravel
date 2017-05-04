@extends('Admin.base.parent')
@section('content')
	<!-- Text Input -->
    <div class="block-area" id="text-input">
        <h3 class="block-title">添加评论</h3>
        @if(count($errors) > 0)
            <div class='alert alert-danger'>
                <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </ul>
            </div>
        @endif
        <p>添加评论</p>
        
        <div class="row">
            <form action="{{ url('admin/comment') }}" method='post'>
                {{ csrf_field() }}
                <input type="hidden" class="form-control m-b-10" name='comment_pubtime'>
                <div class="col-lg-4">
                    <input type="text" class="form-control m-b-10" placeholder="请输入评论内容" name='comment_body'>
                </div>
                <div class="col-lg-4">
                    <input type="text" class="form-control m-b-10" placeholder="请输入商品id" name='comment_gid'>
                </div>
                <div class="col-lg-4">
                    <select class="form-control m-b-10" name='comment_classify'>
                        <option>--请选择评论分等--</option>
                        <option value='1'>极差</option>
                        <option value='2'>差</option>
                        <option value="3">一般</option>
                        <option value="4">好</option>
                        <option value="5">极好</option>
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