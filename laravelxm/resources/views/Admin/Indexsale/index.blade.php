@extends('Admin.base.parent')
@section('content')
	<div class='block-area' id='tableHover'>
		<h3 class='block-title'>楼层展示列表</h3>
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
			<form action="{{ url('admin/indexsale') }}" method='post' name='myform'>
				{{ csrf_field() }}
				{{ method_field('DELETE') }}
			</form>
			<form action="{{ url('admin/indexsale') }}" method='get'>
				<div class='medio-body'>
					楼层板块：<input type='text' class='form-control input-smm-b-10' name='index_sale_area'>		
				</div>
				<div class='medio-body'>
					商品ID：<input type='text' class='form-control input-smm-b-10' name='goods_id'>		
				</div>
				<input type='submit' class='btn' value='搜索'>
			</form>
			<table class='table table-bordered table-hover tile'>
				<thead>
					<tr>
						<th>ID</th>
						<th>楼层板块</th>
						<th>展示商品标题</th>
						<th>商品关键字</th>
						<th>商品id</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
					@foreach($list as $v)
					<tr>
						<td>{{ $v->index_sale_id }}</td>
						<td>{{ $v->index_sale_area }}</td>
						<td>{{ $v->index_sale_title }}</td>
						<td>{{ $v->index_sale_keywords }}</td>
						<td>{{ $v->goods_id }}</td>
						<td>
							<a class='btn btn-sm btn-alt m-r-5' href="{{ url('admin/indexsale').'/'.$v->index_sale_id }}/edit">修改</a>
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
			form.action = '/admin/indexsale/'+id;
			form.submit();
		}
	}
	</script>
@endsection