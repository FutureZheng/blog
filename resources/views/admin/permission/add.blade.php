<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="{{ asset('css/admin/ch-ui.admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/font-awesome.min.css') }}">
</head>
<body>
<!--面包屑导航 开始-->
<div class="crumb_warp">
    <i class="fa fa-home"></i> <a href="#">首页</a> &raquo; <a href="#">角色管理</a> &raquo; 添加角色
</div>
<!--面包屑导航 结束-->

{{--快捷操作--}}
<!--结果集标题与导航组件 开始-->
<div class="result_wrap">
    <div class="result_title">
        <h3>快捷操作</h3>
    </div>
    <div class="result_content">
        <div class="short_wrap">
            <a href="{{ url('admin/permission/index') }}"><i class="fa fa-compress"></i>权限列表</a>
        </div>
    </div>
</div>
<!--结果集标题与导航组件 结束-->

<div class="result_wrap">
    <form action="{{ url('admin/permission/store') }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <table class="add_tab">
            <tbody>
            <tr>
                <th>权限名：</th>
                <td>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="请输入权限名">
                    <span><i class="fa fa-exclamation-circle yellow"></i>这里是默认长度</span>
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i>权限描述信息：</th>
                <td>
                    <input type="text" class="lg" name="description" value="{{ old('description') }}" placeholder="请输入权限的描述信息">
                    <i>{{ $errors->first('description') }}</i>
                    <p>标题可以写30个字</p>
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i>权限访问的url：</th>
                <td>
                    <textarea placeholder="请输入需要访问的权限url,(不用输入http://)（多个url中间用,隔开）" class="lg" name="url">{{ old('url') }}</textarea>
                    <i>{{ $errors->first('description') }}</i>
                    <p>访问的权限需要设置/</p>
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