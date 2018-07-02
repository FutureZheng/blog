<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
    <style>
        * {padding:0;margin:0;}
        .mlr10 {margin-left: 10px;margin-right:10px;}
        .ml10 {margin-left: 10px;}
        .w60 {width: 60%;}
        .w15 {width: 15%;}
        .w25 {width: 25%;}
        .header {
            width: 100%;
            height: 80px;
            background: #383850;
        }
        .user{ float: right;color:#fff;margin: 10px;}
        .username {margin-left: 10px;margin-right: 10px;}
        .logout:hover {}
        select {
            width:10%;
            height: 30px;
            border-radius: 5px;
        }
        .select_op {
            margin: 10px;
            float:left;
        }
        .select_api {
            display: inline-block;
            margin-left: 5px;
        }
        .main {
            display: flex;
            padding: 40px;
        }
        .left{
            flex: 2;
        }
        .right{
            flex: 1;
        }
        ul li {list-style: none;}
        ul li label {
            text-align: right;
            width: 100px;
            display: inline-block;
        }
        ul input {
            height: 30px;
            margin: 10px 0px;
            vertical-align: middle;
            padding-left:20px;
        }
        .btn {
            display: inline-block;
            padding: 6px 12px;
            margin-bottom: 0;
            font-size: 14px;
            font-weight: 400;
            line-height: 1.42857143;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            -ms-touch-action: manipulation;
            touch-action: manipulation;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            background-image: none;
            border: 1px solid transparent;
            border-radius: 4px;
        }
        .form-control {
            display: inline-block;
            /*width: 60%;*/
            padding: 6px 12px;
            font-size: 14px;
            line-height: 1.42857143;
            color: #555;
            background-color: #fff;
            background-image: none;
            border: 1px solid #ccc;
            border-radius: 4px;
            -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
            box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
            -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
            -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
            transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
        }
        .btn-info:hover {
            color: #fff;
            background-color: #31b0d5;
            border-color: #269abc;
        }
        .btn-info {
            color: #fff;
            background-color: #5bc0de;
            border-color: #46b8da;
        }
        .btn-danger {
            color: #fff;
            background-color: #d9534f;
            border-color: #d43f3a;
        }
        .list {margin: 15px;}
        .list h4 {
            background: #ddd;
            padding: 5px;
        }
        .list li {
            margin: 10px;
        }
        .log {
            width: 100%;
            height: 500px;
        }
        .log h2{
            font-size: 18px;
            background: #fff;
            margin-left: 15px;
            margin-top: 15px;
            margin-bottom: 15px;
            font-weight: normal;
        }
        .log .log-content {
            width: 90%;
            height: 400px;
            color: #000;
            padding: 10px;
            border: 1px solid #ddd;
            overflow: scroll;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<div class="header">
    <select class="select_op">
        <option value="0">服务器列表</option>
        <option value="1">本地服务器</option>
        <option value="2">远程服务器</option>
    </select>
    <div class="user"><span class="username">用户名：root</span><span class="logout">登出</span></div>
</div>
<div class="main">
    <div class="left">
        <div>
        <ul>
            <li><label>请求的方式：</label><input type="radio" name="method" value="0"><span class="mlr10">GET</span><input type="radio" name="method" value="1"><span class="mlr10">POST</span></li>
            <li>
                服务器API：
                <select class="select_api" class="form-control">
                    <option value="0">111</option>
                    <option value="1">222</option>
                    <option value="2">333</option>
                </select>
            </li>
            <li><label>URL：</label><input type="text" class="form-control  w60"/></li>
            <li><label>参数：</label><input type="text" class="form-control w60" /><button class="btn btn-info ml10" id="send">添加参数</button></li>
        </ul>
        </div>
        <div class="log">
            <h2>请求结果：</h2>
            <div class="log-content">

            </div>
        </div>
    </div>
    <div class="right">
        <div class="list">
            <div class="file-list">
                <h4>日志文件</h4>
                <ul>
                    @if( $files )
                        @foreach( $files as $file)
                            <li><a href="{{ url('tool/index/getFileContent', $file) }}" target="_blank">{{ $file }}}</a></a></li>
                        @endforeach
                    @endif
                </ul>
            </div>
            <div class="method-url">
                <h4>请求过的URL</h4>
                <ul>
                    <li>a.text</li>
                    <li>a.text</li>
                    <li>a.text</li>
                    <li>a.text</li>
                    <li>a.text</li>
                </ul>
            </div>
        </div>
    </div>
</div>

</body>
</html>
