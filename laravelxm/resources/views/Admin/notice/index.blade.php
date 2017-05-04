@extends('Admin.base.parent')
@section('content')
    <div class="block-area" id="tableHover">
        <h3 class="block-title">公告信息列表</h3>
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
            <form action='/notice' method='post' name='myform'>
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
            </form>

            <form action='/admin/notice' method='get'>
                <div class='medio-body'>
                    公告标题：<input type='text' class='form-control input-sm m-b-10' name='notice_title'>
                </div>
                <input type='submit' class='btn' value='搜索'>
            </form>
            <table class="table table-bordered table-hover tile">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>公告标题</th>
                        <th>公告内容</th>
                        <th>公告发表时间</th>
                        <th>公告状态</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($list as $v)
                        <tr>
                            <td>{{ $v->notice_id }}</td>
                            <td>{{ $v->notice_title }}</td>
                            <td>{{ $v->notice_content }}</td>
                            <td>{{ date("Y-m-d H:i:s",$v->notice_time) }}</td>
                            <td>{{ ($v->notice_type == 1)?'重要':'不重要' }}</td>
                            <td>
                                <a class="btn btn-sm btn-alt m-r-5" href='javascript:doDel({{ $v->notice_id }})'>删除</a>
                                <a class="btn btn-sm btn-alt m-r-5" href='/admin/notice/{{ $v->notice_id }}/edit'>修改</a>
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
                form.action = 'notice/'+id;
                form.submit();
            }
        }
    </script>
@endsection