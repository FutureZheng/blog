<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="{{ asset('css/admin/ch-ui.admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/font-awesome.min.css') }}">
</head>
<body style="background:#F3F3F4;">
<div class="login_box">
    <h1>Blog</h1>
    <h2>欢迎使用博客管理平台</h2>
    <div class="form">
        {{-- 这边填写错误信息 --}}
        @if( session('message') )
            <p style="color:red">{{ session('message') }}</p>
        @elseif( $errors )
            <p style="color:red">{{ $errors->first() }}</p>
        @endif
        <form action="{{ url('admin/login/login') }}" method="post">
            {{ csrf_field() }}
            <ul>
                <li>
                    <input type="text" name="email" value="{{ old('email') }}" placeholder="请输入您的邮箱" class="text"/>
                    <span><i class="fa fa-user"></i></span>
                </li>
                <li>
                    <input type="password" name="password" placeholder="请输入密码" class="text"/>
                    <span><i class="fa fa-lock"></i></span>
                </li>
                <li>
                    <input type="submit" value="立即登陆"/>
                </li>
            </ul>
        </form>
        <p><a href="#">返回首页</a> &copy; 2016 Powered by <a href="http://www.houdunwang.com" target="_blank">http://www.houdunwang.com</a></p>
    </div>
</div>
</body>
</html>