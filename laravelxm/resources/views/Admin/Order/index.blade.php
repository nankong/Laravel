@extends('Admin.base.parent')
@section('content')
    <div class="block-area" id="tableHover">
        <h3 class="block-title">订单信息列表</h3>
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
            <form action="{{ url('/admin/order') }}" method='post' name='myform'>
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
            </form>

            <form action="{{ url('/admin/order') }}" method="get">
                <div class='medio-body'>
                    订单编号：<input type='text' class='form-control input-sm m-b-10' name='id'>
                </div>
                <!-- <div>
                    性别：<select name='sex' class='form-control input-sm m-b-10'>
                        <option value=''>--请选择--</option>
                        <option value='1'>--男--</option>
                        <option value='2'>--女--</option>
                    </select>
                </div> -->
                <input type='submit' class='btn' value='搜索'>
            </form>
            <table class="table table-bordered table-hover tile">
                <thead>
                    <tr>
                        <th>订单编号</th>
                        <th>订单状态</th>
                        <th>下单时间</th>
                        <th>收货人</th>
                        <th>商品小计</th>
                        <th>收货地址</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($list as $v)
                        <tr>
                            <td>{{ $v->order_od_numb }}</td>
                            <td>@if($v->order_state == 0) 待付款 @elseif($v->order_state == 1) 已付款 @elseif($v->order_state == 2) 待发货 @elseif($v->order_state == 3) 已发货 @elseif($v->order_state == 4) 待收货 @elseif($v->order_state == 5) 已收货 @elseif($v->order_state == 6) 已评价 @elseif($v->order_state == 7) 交易成功 @endif</td>
                            <td>{{ $v->order_time }}</td>
                            <td>{{ $v->order_name }}</td>
                            <td>{{ $v->order_pricesum }}</td>
                            <td>{{ $v->order_detail }}</td>
                            <td>
                                <a class="btn btn-sm btn-alt m-r-5" href='javascript:doDel({{ $v->order_od_numb }})'>删除</a>
                                <a class="btn btn-sm btn-alt m-r-5" href='{{ url("/admin/order") }}/{{ $v->order_id }}/edit'>修改</a>
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
                form.action = '{{ url("/admin/order")."/" }}'+id;
                form.submit();
            }
        }
    </script>
@endsection