@extends('Admin.base.parent')
@section('content')
	<!-- Text Input -->
    <div class="block-area" id="text-input">
        <h3 class="block-title">修改商品</h3>
        
        <p>填空修改商品</p>
        
        <div class="row">
            <form action='{{ url("admin/indexsale")."/".$ob->index_sale_id }}' method='post'>
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="col-lg-4">
                    <input type="text" class="form-control m-b-10" placeholder="请输入楼层区域" name='index_sale_area' value="{{ $ob->index_sale_area }}">
                    <input type="text" class="form-control m-b-10" placeholder="请输入标题" name='index_sale_title' value="{{ $ob->index_sale_title }}">
                    <input type="text" class="form-control m-b-10" placeholder="请输入关键词" name='index_sale_keywords' value="{{ $ob->index_sale_keywords }}">
                </div>
                <div class="col-lg-12">
                    <input type='submit' class="btn btn-block btn-alt" value='提交'>
                </div>
            </form>
        </div>
        <p></p>
        
    </div>
@endsection