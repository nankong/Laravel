@extends('Admin.base.parent')
@section('content')
	<div class='block-area' id='tableHover'>
		<h3 class='block-title'>商品列表</h3>
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
			<form action="{{ url('admin/goods') }}" method='post' name='myform'>
				{{ csrf_field() }}
				{{ method_field('DELETE') }}
			</form>
			<form action="{{ url('admin/goods') }}" method='get'>
				<div class='medio-body'>
					商品ID：<input type='text' class='form-control input-smm-b-10' name='goods_id'>		
				</div>
				<div class='medio-body'>
					商品名字：<input type='text' class='form-control input-smm-b-10' name='goods_name'>		
				</div>
				<input type='submit' class='btn' value='搜索'>
			</form>
			<table class='table table-bordered table-hover tile'>
				<thead>
					<tr>
						<th>ID</th>
						<th>商品名字</th>
						<th>标题(关键字)</th>
						<th>上市时间</th>
						<th>状态</th>
						<th>出售价格</th>
						<th>数量</th>
						<th>参数</th>
						<th>demo图片</th>
						<th>商品类别</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
					@foreach($list as $a=>$v)
					<tr>
						<td>{{ $v->goods_id }}</td>
						<td>{{ $v->goods_name }}</td>
						<td>{{ $v->goods_keywords }}</td>
						<td>{{ date("Y-m-d H:i:s", $v->goods_time) }}</td>
						<td>{{ $v->goods_state }}</td>
						<td>{{ $v->goods_sale_price }}</td>
						<td>{{ $v->goods_num }}</td>
						<td>
							@foreach($avalue as $k=>$av)
								@if(in_array($avalue[$k]->avalue_id, $goods_attr_value[$a]))
									@foreach($store_attr as $attr)
										@if($attr->attr_id == $avalue[$k]->attr_id)
										{{ $attr->attr_name }} :
										@endif
									@endforeach
									 {{ $avalue[$k]->avalue_value }}，
								@endif
							@endforeach 
						</td>
						<td><img width="60" height="60"  src="{{ asset('Admin/upload')}}/{{ $v->goods_big_pic}}"></td>
							@foreach($category as $c)
	                           	@if($v->category_id == $c->category_id)
	                               <td>{{ $c->category_name }}</td>
	                               @break
								@endif
	                        @endforeach
						<td>
							<a class='btn btn-sm btn-alt m-r-5' href="javascript:doDel({{ $v->goods_id }})">删除</a>
							<a class='btn btn-sm btn-alt m-r-5' href="{{ url('admin/goods').'/'.$v->goods_id }}/edit">修改</a>
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
			form.action = '/admin/goods/'+id;
			form.submit();
		}
	}
	</script>
@endsection