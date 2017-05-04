@extends('Admin.base.parent')
@section('content')
	<div class='block-area' id='tableHover'>
		<h3 class='block-title'>购物列表</h3>
		@if(session('msg'))
			<div class='alert alert-success alert-icon'>
				{{ session('msg') }}
				<i class='icon'></i>
			</div>
		@endif
		@if(session('error'))
			<div class='alert alert-warning alert-icon'>
			{{ session('error') }}
			<i class='icon'></i>
			</div>
		@endif
		<div class='table-responsive overflow'>
			<form action="{{ url('admin/temprory') }}" method='post' name='myform'>
				{{ csrf_field() }}
				{{ method_field('DELETE') }}
			</form>
			<form action="{{ url('admin/temprory') }}" method='get'>
				<div class='medio-body'>
					商品ID：<input type='text' class='form-control input-smm-b-10' name='temprory_gid'>		
				</div>
				<div class='medio-body'>
					用户ID：<input type='text' class='form-control input-smm-b-10' name='temprory_uid'>		
				</div>
				<input type='submit' class='btn' value='搜索'>
			</form>
			<table class='table table-bordered table-hover tile'>
				<thead>
					<tr>
						<th>ID</th>
						<th>商品id</th>
						<th>用户id</th>
						<th>商品数量</th>
						<th>商品图片</th>
						<th>商品价格</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
					@foreach($list as $v)
					<tr>
						<td>{{ $v->temprory_id }}</td>
						<td>{{ $v->temprory_gid }}</td>
						<td>{{ $v->temprory_uid }}</td>
						<td>{{ $v->temprory_num }}</td>
						<td><img width="60" height="60" src="{{ asset('Admin/upload') }}/{{ $v->temprory_pic }}"></td>
						<td>{{ $v->temprory_price }}</td>
						<td>
							<a class='btn btn-sm btn-alt m-r-5' href="javascript:doDel({{ $v->temprory_id }})">删除</a>
							<a class='btn btn-sm btn-alt m-r-5' href="{{ url('admin/temprory').'/'.$v->temprory_id }}/edit">修改</a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			{{ $list->appends($where)->links() }}
		</div>
	</div>
	<script type="text/javascript">
	function doDel(id){
		if(confirm('确定删除吗？')){
			var form = document.myform;
			form.action = '/admin/temprory/'+id;
			form.submit();
		}
	}
	</script>
@endsection