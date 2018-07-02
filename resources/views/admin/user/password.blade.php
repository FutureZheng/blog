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
        <h3>修改密码</h3>
        @if( session('message'))
            <div class="mark">
                <p>{{ session('message') }}</p>
            </div>
        @endif
    </div>
</div>
<!--结果集标题与导航组件 结束-->

<div class="result_wrap">
    {{--return changePass()--}}
    <form method="post" action="{{ url('admin/user/changePassword') }}">
        {{ csrf_field() }}
        <table class="add_tab">
            <tbody>
            <tr>
                <th width="120"><i class="require">*</i>原密码：</th>
                <td>
                    <input type="password" value="{{ old('old_password') }}" name="old_password">
                    <i>{{ $errors->first('old_password') }}</i>
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i>新密码：</th>
                <td>
                    <input type="password" name="new_password"> <i>{{ $errors->first('new_password') }}</i>
                    {{--<i>新密码6-20位</i>--}}
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i>确认密码：</th>
                <td>
                    <input type="password" name="new_password_confirmation" /> <i>{{ $errors->first('new_password_confirmation') }}</i>
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