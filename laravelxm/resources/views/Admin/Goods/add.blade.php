@extends('Admin.base.parent')
@section('content')
	<!-- Text Input -->
    <div class="block-area" id="text-input">
        <h3 class="block-title">添加商品</h3>
        @if(count($errors) > 0)
            <div class='alert alert-danger'>
                <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </ul>
            </div>
        @endif
        <p>添加商品</p>
        
        <div class="row">
            <form action="{{ url('admin/goods') }}" method='post' enctype='multipart/form-data'>
                {{ csrf_field() }}
                <input type="hidden" class="form-control m-b-10" name='goods_time'>
                <div class="col-lg-4">

                    <select class="form-control m-b-10" name='category_id'>
                        <option>--请选择商品类别--</option>
                        @foreach($category as $v)
                            <option value="{{ $v->category_id }}">{{ $v->category_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-4">
                    <input type="text" class="form-control m-b-10" placeholder="请输入商品名字" name='goods_name'>
                </div>
                <div class="col-lg-4">
                    <input type="text" class="form-control m-b-10" placeholder="请输入商品关键字" name='goods_keywords'>
                </div>
                <div class="col-lg-4">
                    <input type="text" class="form-control m-b-10" placeholder="请输入商品状态" name='goods_state'>
                </div>
                <div class="col-lg-4">
                    <input type="text" class="form-control m-b-10" placeholder="请输入商品价格" name='goods_sale_price'>
                </div>
                <div class="col-lg-4">
                    <input type="text" class="form-control m-b-10" placeholder="请输入商品数量" name='goods_num'>
                </div>
               <!--  <div class="col-lg-2">
                    <input type="text" class="form-control m-b-10" disabled="" placeholder="请上传一张图片" name='goods_demo_pic'>
                </div>
                <div class="fileupload fileupload-new" data-provides="fileupload">
                    <span class="btn btn-file btn-sm btn-alt">
                        <span class="fileupload-new">Select file</span>
                        <span class="fileupload-exists">Change</span>
                        <input type="file" name='goods_demo_pic'/>
                    </span>
                    <span class="fileupload-preview"></span>
                    <a href="#" class="close close-pic fileupload-exists" data-dismiss="fileupload">
                        <i class="fa fa-times"></i>
                    </a>
                </div> -->
                <div class="col-lg-12">
                    <input type='submit' class="btn btn-block btn-alt" value='提交'>
                </div>
            </form>
        </div>
        <p></p>
        
    </div>
@endsection