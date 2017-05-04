<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">

</head>
<body>
	<center>
		<h3>浏览用户信息</h3>
		@include('Stu.menu')
		@if(session('info'))
			<script type="text/javascript">
				alert("{{ session('info')}}")
			</script>
		@endif
		<table width="700" border="1">
				<tr>
					<th>学号</th>
					<th>姓名</th>
					<th>性别</th>
					<th>年龄</th>
					<th>操作</th>
				</tr>
				@foreach ($list as $v)
					<tr>
						<td>{{ $v->uid }}</td>
						<td>{{ $v->name }}</td>
						<td>@if ($v->sex == 1) 男 @else 女 @endif</td>
						<td>{{ $v->age }}</td>
						<td>
						<form name="myform" method="post">
							{{ csrf_field() }}
							{{ method_field('DELETE')}}
							<input type="hidden" name="uid" value="{{ $v->uid }}" >
							
							<a href="/stu" onclick="document.myform.submit();">删除</a>
						
						</form>
							<!-- <a href="/stu" onclick="document.myform.submit();">删除</a> -->
							<a href="/stu/{{ $v->uid }}/edit">修改</a>

						</td>
					</tr>
				@endforeach
		</table>
	</center>
</body>
</html>