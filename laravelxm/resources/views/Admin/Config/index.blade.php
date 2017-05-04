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
            <form action="{{ url('/admin/config') }}" method='post' name='myform'>
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
            </form>

            <form action="{{ url('/admin/config') }}" method="get">
                <div class='medio-body'>
                    地址：<input type='text' class='form-control input-sm m-b-10' name='id'>
                </div>
                <input type='submit' class='btn' value='搜索'>
            </form>
            <table class="table table-bconfige table-hover tile">
                <thead>
                    <tr>
                        <th>编号</th>
                        <th>网站标题</th>
                        <th>网站关键字</th>
                        <th>网站介绍</th>
                        <th>网站状态</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($list as $v)
                        <tr>
                            <td>{{ $v->config_id }}</td>
                            <td>{{ $v->config_title }}</td>
                            <td>{{ $v->config_keys }}</td>
                            <td>{{ $v->config_desn }}</td>
                            <td>@if($v->config_state == 0) 维护 @else 开启 @endif</td>
                            <td>
                                <!-- <a class="btn btn-sm btn-alt m-r-5" href='javascript:doDel({{ $v->config_id }})'>删除</a> -->
                                <a class="btn btn-sm btn-alt m-r-5" href='{{ url("/admin/config") }}/{{ $v->config_id }}/edit'>修改</a>
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
                form.action = '{{ url("/admin/config")."/" }}'+id;
                form.submit();
            }
        }
    </script>
@endsection