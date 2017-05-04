@extends('Admin.base.parent')
@section('content')
	<div class='block-area' id='tableHover'>
		<h3 class='block-title'>评论列表</h3>
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
			<form action="{{ url('admin/comment') }}" method='post' name='myform'>
				{{ csrf_field() }}
				{{ method_field('DELETE') }}
			</form>
			<form action="{{ url('admin/comment') }}" method='get'>
				<div class='medio-body'>
					商品ID：<input type='text' class='form-control input-smm-b-10' name='comment_gid'>		
				</div>
				<div class='medio-body'>
					用户ID：<input type='text' class='form-control input-smm-b-10' name='comment_uid'>		
				</div>
				<input type='submit' class='btn' value='搜索'>
			</form>
			<table class='table table-bordered table-hover tile'>
				<thead>
					<tr>
						<th>ID</th>
						<th>评论时间</th>
						<th>评论内容</th>
						<th>商品id</th>
						<th>用户id</th>
						<th>评论分类</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
					@foreach($list as $v)
					<tr>
						<td>{{ $v->comment_id }}</td>
						<td>{{ date("Y-m-d H:i:s", $v->comment_pubtime) }}</td>
						<td>{{ $v->comment_body }}</td>
						<td>{{ $v->comment_gid }}</td>
						<td>{{ $v->comment_uid }}</td>
						<td>{{ ($v->comment_classify) }}</td>
						<td>
							<a class='btn btn-sm btn-alt m-r-5' href="javascript:doDel({{ $v->comment_id }})">删除</a>
							<a class='btn btn-sm btn-alt m-r-5' href="{{ url('admin/comment').'/'.$v->comment_id }}/edit">修改</a>
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
			form.action = '/admin/comment/'+id;
			form.submit();
		}
	}
	</script>
@endsection