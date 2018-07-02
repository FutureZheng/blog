<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    @include('admin.common.style')
</head>
<body>
<!--面包屑导航 开始-->
<div class="crumb_warp">
    <i class="fa fa-home"></i> <a href="#">首页</a> &raquo; 修改密码
</div>
<!--面包屑导航 结束-->

<!--结果集标题与导航组件 开始-->
<div class="result_wrap">
    <div class="result_title">
        <h3>新增用户</h3>
        @if(session('message'))
            <div class="mark">
                <p>{{ session('message') }}</p>
            </div>
        @endif
    </div>
</div>
<!--结果集标题与导航组件 结束-->

<div class="result_wrap">
    {{--return changePass()--}}
    <form method="post" action="{{ url('admin/user/store') }}">
        {{ csrf_field() }}
        <table class="add_tab">
            <tbody>
            <tr>
                <th width="120"><i class="require">*</i>用户名：</th>
                <td>
                    <input type="text" value="{{ old('username') }}" placeholder="请输入您的用户名" name="username">
                    <i>{{ $errors->first('username') }}</i>
                </td>
            </tr>
            <tr>
                <th width="120"><i class="require">*</i>邮件：</th>
                <td>
                    <input type="text" value="{{ old('email') }}" placeholder="请输入您的邮箱" name="email">
                    <i>{{ $errors->first('email') }}</i>
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i>密码：</th>
                <td>
                    <input type="password" name="password" placeholder="请输入密码"> <i>{{ $errors->first('password') }}</i>
                    {{--<i>{{ $errors->first('password') }}</i>--}}
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i>确认密码：</th>
                <td>
                    <input type="password" name="password_confirmation" placeholder="请再次输入密码" />
                </td>
            </tr>
            <tr>
                <th></th>
                <td>
                    <input type="submit" value="提交">
                    <input type="button" class="back" onclick="history.go(-1)" value="返回">
                </td>
            </tr>
            </tbody>
        </table>
    </form>
</div>
</body>
</html>
@include('admin.common.script')