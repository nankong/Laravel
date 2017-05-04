@extends('Admin.base.parent')
@section('content')
	<div class="block-area" category_id="tableHover">
        <h3 class="block-title">类别信息列表</h3>
        @if(session('msg'))
        	<div class="alert alert-success alert-icon">
			{{ session('msg') }}
			<i class="icon"></i>
			</div>
        @endif
        @if(session('error'))
        	<div class="alert alert-warning alert-icon">
			{{ session('error') }}
			<i class="icon"></i>
			</div>
		@endif
        <div class="table-responsive overflow">
        	<form action='{{ url("admin/category") }}' method='post' name='myform'>
        		{{ csrf_field() }}
        		{{ method_field('DELETE') }}
        	</form>

        	<form action='{{ url("admin/category") }}' method='get'>
        		<div class='medio-body'>
    				类别名：<input category='text' class='form-control input-sm m-b-10' name='category_name'>
    			</div>
        		<input type='submit' class='btn' value='搜索'>
        	</form>
            <table class="table table-bordered table-hover tile">
                <thead>
                    <tr>
                        <th>category_id</th>
                        <th>类别名</th>
                        <th>路径</th>
                        <th>父category_id</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($list as $v)
                    	<tr>
	                        <td>{{ $v->category_id }}</td>
	                        <td>{{ $v->category_name }}</td>
	                        <td>{{ $v->category_path }}</td>
	                        <td>{{ $v->category_upid }}</td>
	                        <td>
	                        	<a class="btn btn-sm btn-alt m-r-5" href='javascript:doDel({{ $v->category_id }})'>删除</a>
	                        	<a class="btn btn-sm btn-alt m-r-5" href="{{ url('admin/category').'/'.$v->category_id }}/edit">修改</a>
                                <a class="btn btn-sm btn-alt m-r-5" href="{{ url('admin/categorySon').'/'.$v->category_id }}">添加子类</a>
	                        </td>
	                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $list->appends($where)->links() }}
        </div>
    </div>
    <script category="text/javascript">
        function doDel(category_id){
        	if(confirm('确定删除吗？')){
        		var form = document.myform;
        		form.action = '/admin/category/'+category_id;
        		form.submit();
        	}
        }
    </script>
@endsection