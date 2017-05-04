@extends('Admin.base.parent')
@section('content')
	<div class='block-area' id='tableHover'>
		<h3 class='block-title'>友情链接列表</h3>
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
			<form action="{{ url('admin/links') }}" method='post' name='myform'>
				{{ csrf_field() }}
				{{ method_field('DELETE') }}
			</form>
			<form action="{{ url('admin/links') }}" method='get'>
				<div class='medio-body'>
					名称：<input type='text' class='form-control input-smm-b-10' name='links_name'>		
				</div>
				<div class='medio-body'>
					url地址：<input type='text' class='form-control input-smm-b-10' name='links_url'>		
				</div>
				<input type='submit' class='btn' value='搜索'>
			</form>
			<table class='table table-bordered table-hover tile'>
				<thead>
					<tr>
						<th>ID</th>
						<th>连接名称</th>
						<th>URL地址</th>
						<th>开关</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
					@foreach($list as $v)
					<tr>
						<td>{{ $v->links_id }}</td>
						<td>{{ $v->links_name }}</td>
						<td>{{ $v->links_url }}</td>
						<td>{{ ($v->links_switch == 1)?'开':'关' }}</td>
						<td>
							<a class='btn btn-sm btn-alt m-r-5' href="javascript:doDel({{ $v->links_id }})">删除</a>
							<a class='btn btn-sm btn-alt m-r-5' href="{{ url('admin/links').'/'.$v->links_id }}/edit">修改</a>
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
			form.action = '/admin/links/'+id;
			form.submit();
		}
	}
	</script>
@endsection