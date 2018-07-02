<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>后台的首页 @yield('title')</title>
    @include('admin.common.style')
    @section('style')@show
</head>
<body>
<!--头部 开始-->
<div class="top_box">
    @section('header')
    <div class="top_left">
        <div class="logo">博客后台管理</div>
        </ul>
    </div>
    <div class="top_right">
        <ul>
            <li>管理员：{{ session('user')->username }}</li>
            <li><a href="{{ url('admin/user/password') }}" target="main">修改密码</a></li>
            <li><a href="{{ url('admin/login/logout') }}">退出</a></li>
        </ul>
    </div>
    @show
</div>
<!--头部 结束-->

<!--左侧导航 开始-->
<div class="menu_box">
    @section('sidebar')
    <ul>
        <li>
            <h3><i class="fa fa-fw fa-clipboard"></i>用户管理</h3>
            <ul class="sub_menu">
                <li><a href="{{ url('admin/user/index') }}" target="main"><i class="fa fa-fw fa-plus-square"></i>用户列表</a></li>
            </ul>
        </li>
        <li>
            <h3><i class="fa fa-fw fa-clipboard"></i>文章管理</h3>
            <ul class="sub_menu">
                <li><a href="{{ url('admin/article/index') }}" target="main"><i class="fa fa-fw fa-plus-square"></i>文章列表</a></li>
            </ul>
        </li>
        <li>
            <h3><i class="fa fa-fw fa-cog"></i>权限管理</h3>
            <ul class="sub_menu">
                <li><a href={{ url('admin/role/index') }} target="main"><i class="fa fa-fw fa-cubes"></i>角色列表</a></li>
                <li><a href={{ url('admin/permission/index') }} target="main"><i class="fa fa-fw fa-cubes"></i>权限列表</a></li>

            </ul>
        </li>
        <li>
            <h3><i class="fa fa-fw fa-cog"></i>系统设置</h3>
            <ul class="sub_menu">
                <li><a href={{ url('admin/system/info') }} target="main"><i class="fa fa-fw fa-cubes"></i>网站配置</a></li>
                <li><a href={{ url('admin/system/backup') }} target="main"><i class="fa fa-fw fa-cubes"></i>备份还原</a></li>
            </ul>
        </li>
        <li>
            <h3><i class="fa fa-fw fa-thumb-tack"></i>工具导航</h3>
            <ul class="sub_menu">
                <li><a href="http://www.yeahzan.com/fa/facss.html" target="main"><i class="fa fa-fw fa-font"></i>图标调用</a></li>
                <li><a href="http://hemin.cn/jq/cheatsheet.html" target="main"><i class="fa fa-fw fa-chain"></i>Jquery手册</a></li>
                <li><a href="http://tool.c7sky.com/webcolor/" target="main"><i class="fa fa-fw fa-tachometer"></i>配色板</a></li>
                <li><a href="element.html" target="main"><i class="fa fa-fw fa-tags"></i>其他组件</a></li>
            </ul>
        </li>
    </ul>
    @show
</div>
<!--左侧导航 结束-->

<!--主体部分 开始-->
<div class="main_box">
    @yield('content')
</div>
<!--主体部分 结束-->

<!--底部 开始-->
<div class="bottom_box">
    @section('footer')
        CopyRight © 2015. Powered By <a href="http://www.houdunwang.com">http://www.houdunwang.com</a>.
    @show
</div>
<!--底部 结束-->
</body>
</html>
@include('admin.common.script')
@section('script')@show