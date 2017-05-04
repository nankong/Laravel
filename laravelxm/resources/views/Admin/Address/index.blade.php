@extends('Admin.base.parent')
@section('content')
    <div class="block-area" id="tableHover">
        <h3 class="block-title">收货地址列表</h3>
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
            <form action="{{ url('/admin/address') }}" method='post' name='myform'>
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
            </form>

            <form action="{{ url('/admin/address') }}" method="get">
                <div class='medio-body'>
                    手机号：<input type='text' class='form-control input-sm m-b-10' name='id'>
                </div>
                <input type='submit' class='btn' value='搜索'>
            </form>
            <table class="table table-baddresse table-hover tile">
                <thead>
                    <tr>
                        <th>编号</th>
                        <th>用户ID</th>
                        <th>收货人</th>
                        <th>收货人手机号</th>
                        <th>是否是默认地址</th>
                        <th>详细地址</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($list as $v)
                        <tr>
                            <td>{{ $v->address_id }}</td>
                            <td>{{ $v->address_uid }}</td>
                            <td>{{ $v->address_consignee }}</td>
                            <td>{{ $v->address_consignee_phone }}</td>
                            <td>@if($v->address_default == 0) 否 @else 是 @endif</td>
                            <td>{{ $v->address_detail }}</td>
                            <td>
                                <a class="btn btn-sm btn-alt m-r-5" href='javascript:doDel({{ $v->address_id }})'>删除</a>
                                <a class="btn btn-sm btn-alt m-r-5" href='{{ url("/admin/address") }}/{{ $v->address_id }}/edit'>修改</a>
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
                form.action = '{{ url("/admin/address")."/" }}'+id;
                form.submit();
            }
        }
    </script>
@endsection