@extends('Admin.base.parent')
@section('content')
    <div class="block-area" id="tableHover">
        <h3 class="block-title">用户信息列表</h3>
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
            <form action='/demo4' method='post' name='myform'>
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
            </form>

            <form action='/admin/demo4' method='get'>
                <div class='medio-body'>
                    姓名：<input type='text' class='form-control input-sm m-b-10' name='user_username'>
                </div>
                <div>
                    性别：<select name='user_sex' class='form-control input-sm m-b-10'>
                        <option value=''>--请选择--</option>
                        <option value='1'>--男--</option>
                        <option value='2'>--女--</option>
                    </select>
                </div>
                <input type='submit' class='btn' value='搜索'>
            </form>
            <table class="table table-bordered table-hover tile">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>用户名</th>
                        <th>密码</th>
                        <th>性别</th>
                        <th>邮编</th>
                        <th>收藏物品的ID</th>
                        <th>注册时间</th>
                        <th>状态</th>
                        <th>电话</th>
                        <th>邮箱</th>
                        <th>积分</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($list as $v)
                        <tr>
                            <td>{{ $v->user_id }}</td>
                            <td>{{ $v->user_username }}</td>
                            <td>{{ $v->user_pass }}</td>
                            <td>{{ ($v->user_sex == 1)?'男':'女' }}</td>
                            <td>{{ $v->user_code }}</td>
                            <td>{{ $v->user_store }}</td>
                            <td>{{ date("Y-m-d H:i:s",$v->user_time) }}</td>
                            <td>{{ $v->user_state }}</td>
                            <td>{{ $v->user_tel }}</td>
                            <td>{{ $v->user_uemail }}</td>
                            <td>{{ $v->user_integral }}</td>
                            <td>
                                <a class="btn btn-sm btn-alt m-r-5" href='javascript:doDel({{ $v->user_id }})'>删除</a>
                                <a class="btn btn-sm btn-alt m-r-5" href='/admin/demo4/{{ $v->user_id }}/edit'>修改</a>
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
                form.action = 'demo4/'+id;
                form.submit();
            }
        }
    </script>
@endsection