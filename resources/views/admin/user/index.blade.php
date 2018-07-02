<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="{{ asset('css/admin/ch-ui.admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/font-awesome.min.css') }}">
    <script type="text/javascript" src="{{ asset('js/admin/jquery.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/admin/ch-ui.admin.js') }}"></script>
</head>
<body>
<!--面包屑导航 开始-->
<div class="crumb_warp">
    <i class="fa fa-home"></i> <a href="#">首页</a> &raquo; <a href="#">用户管理</a> &raquo; 用户列表
</div>
<!--面包屑导航 结束-->
@if( session('message'))
<div class="result_title">
    <div class="mark">
        <p>{{ session('message') }}</p>
    </div>
</div>
@endif

<!--结果页快捷搜索框 开始-->
<div class="search_wrap">
    <form action="{{ url('admin/user/index') }}" method="post">
        {{ csrf_field() }}
        <table class="search_tab">
            <tr>
                <th width="120">选择分类:</th>
                <td>
                    <select name="condition" >
                        <option value="">全部</option>
                        <option value="username" @if( strcmp($condition, 'username') === 0)selected="selected"@endif >用户姓名</option>
                        <option value="email" @if( strcmp($condition, 'email') === 0)selected="selected"@endif >用户邮箱</option>
                        <option value="status" @if( strcmp($condition, 'status') === 0)selected="selected"@endif >用户状态</option>
                    </select>
                </td>
                <th width="70">关键字:</th>
                <td><input type="text" name="keywords" value="{{ $keywords }}" placeholder="关键字"></td>
                <td><input type="submit" name="sub" value="查询"></td>
            </tr>
        </table>
    </form>
</div>
<!--结果页快捷搜索框 结束-->

<!--搜索结果页面 列表 开始-->
<form action="#" method="post">

    @include('admin.common.user')

    <div class="result_wrap">
        <div class="result_content">
            <table class="list_tab">
                <tr>
                    <th class="tc">ID</th>
                    <th>用户姓名</th>
                    <th>用户的邮箱</th>
                    <th>是否为管理员</th>
                    <th>状态</th>
                    <th>最后登录的ip</th>
                    <th>最后登录的时间</th>
                    <th>操作</th>
                </tr>

                @if( $users->isNotEmpty())
                @foreach($users as $user)
                <tr>
                    <td class="tc">{{ $user->id }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $userRepository->getIsAdminMessage($user->is_admin) }}</td>
                    <td>{{ $userRepository->getStatusMessage($user->status) }}</td>
                    <td>{{ $user->login_ip }}</td>
                    <td>{{ $user->login_at }}</td>
                    <td>
                        <a href="{{ url('admin/user/edit', $user->id) }}">编辑用户</a>
                        <a href="{{ url('admin/user/role', $user->id) }}">设置角色</a>
                        <a href="{{ url('admin/user/delete', $user->id) }}" onclick="return confirm('确认要删除数据吗？')">删除</a>
                    </td>
                </tr>
                @endforeach
                @else
                    <tr>
                        <td colspan="9" style="text-align: center">暂无记录</td>
                    </tr>
                @endif
            </table>

            {{--<div class="page_nav">--}}
                {{--<div>--}}
                    {{--<a class="first" href="/wysls/index.php/Admin/Tag/index/p/1.html">第一页</a>--}}
                    {{--<a class="prev" href="/wysls/index.php/Admin/Tag/index/p/7.html">上一页</a>--}}
                    {{--<a class="num" href="/wysls/index.php/Admin/Tag/index/p/6.html">6</a>--}}
                    {{--<a class="num" href="/wysls/index.php/Admin/Tag/index/p/7.html">7</a>--}}
                    {{--<span class="current">8</span>--}}
                    {{--<a class="num" href="/wysls/index.php/Admin/Tag/index/p/9.html">9</a>--}}
                    {{--<a class="num" href="/wysls/index.php/Admin/Tag/index/p/10.html">10</a>--}}
                    {{--<a class="next" href="/wysls/index.php/Admin/Tag/index/p/9.html">下一页</a>--}}
                    {{--<a class="end" href="/wysls/index.php/Admin/Tag/index/p/11.html">最后一页</a>--}}
                    {{--<span class="rows">11 条记录</span>--}}
                {{--</div>--}}
            {{--</div>--}}

            <div class="page_list">
                {{--<ul>--}}
                    {{--<li class="disabled"><a href="#">&laquo;</a></li>--}}
                    {{--<li class="active"><a href="#">1</a></li>--}}
                    {{--<li><a href="#">2</a></li>--}}
                    {{--<li><a href="#">3</a></li>--}}
                    {{--<li><a href="#">4</a></li>--}}
                    {{--<li><a href="#">5</a></li>--}}
                    {{--<li><a href="#">&raquo;</a></li>--}}
                {{--</ul>--}}
                {{ $users->render() }}
            </div>

        </div>
    </div>
</form>
<!--搜索结果页面 列表 结束-->
</body>
</html>