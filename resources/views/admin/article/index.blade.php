<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../css/admin/ch-ui.admin.css">
    <link rel="stylesheet" href="../../css/admin/font-awesome.min.css">
    <script type="text/javascript" src="../../js/admin/jquery.js"></script>
    <script type="text/javascript" src="../../js/admin/ch-ui.admin.js"></script>
</head>
<body>
<!--面包屑导航 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="#">首页</a> &raquo; <a href="#">文章管理</a> &raquo; 文章列表
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
    <form action="{{ url('admin/article/index') }}" method="get">
        {{ csrf_field() }}
        <table class="search_tab">
            <tr>
                <th width="120">选择分类:</th>
                <td>
                    <select name="key">
                        <option value="">全部</option>
                        <option value="id" @if( strcmp($search['key'], 'id') == 0 ) selected="selected" @endif >文章id</option>
                        <option value="title" @if( strcmp($search['key'], 'title') == 0) selected="selected" @endif >文章标题</option>
                        <option value="author" @if( strcmp($search['key'], 'author') == 0) selected="selected" @endif>文章发布人</option>
                    </select>
                </td>
                <th width="70">关键字:</th>
                <td><input type="text" name="keywords" value="{{ $search['keywords'] }}" placeholder="关键字"></td>
                <th width="120">文章的状态:</th>
                <td>
                    <select name="status">
                        <option value="">全部</option>
                        <option value="0" @if( strcmp($search['status'], 0)  === 0) selected="selected" @endif >审核中</option>
                        <option value="1" @if( strcmp($search['status'], 1)  === 0) selected="selected" @endif >发表中的问题张</option>
                        <option value="2" @if( strcmp($search['status'], 2)  === 0) selected="selected" @endif >下架中的文章</option>
                    </select>
                </td>
                <th width="70"><input type="submit" name="sub" value="查询"></th>
            </tr>
        </table>
    </form>
</div>
<!--结果页快捷搜索框 结束-->

<!--搜索结果页面 列表 开始-->
<form action="#" method="post">
    {{--快捷操作--}}
    @include('admin.common.operate')
    <div class="result_wrap">
        <div class="result_content">
            <table class="list_tab">
                <tr>
                    <th class="tc" width="5%"><input type="checkbox" name=""></th>
                    <th class="tc">id</th>
                    <th>标题</th>
                    <th>描述信息</th>
                    <th>文章正文</th>
                    <th>点击</th>
                    <th>作者</th>
                    <th>是否为博主推荐文章</th>
                    <th>审核状态</th>
                    <th>审核人员</th>
                    <th>审核时间</th>
                    <th>更新时间</th>
                    <th>操作</th>
                </tr>

                @if( $articles->isNotEmpty())
                @foreach( $articles as $article)
                    <tr>
                        <td class="tc"><input type="checkbox" name="id[]" value="59"></td>
                        <td class="tc">{{ $article->id }}</td>
                        <td>{{ $article->title }}</td>
                        <td>{{ mb_substr($article->description, 0, 10) }}</td>
                        <td>{{ mb_substr(html_entity_decode($article->content, ENT_HTML401, 'UTF-8'), 0, 50) }}</td>
                        <td>{{ $article->number }}</td>
                        <td>{{ $article->author }}</td>
                        <td>{{ $Article->getArticleIsRecommend($article->is_recommend) }}</td>
                        <td>{{ $Article->getArticleStatus($article->status) }}</td>
                        <td>{{ $UserRepository->getUserNameById($article->audit_admin_id) }}</td>
                        <td>{{ $article->audit_at }}</td>
                        <td>{{ $article->updated_at }}</td>
                        <td>
                            <a href="{{ url('admin/article/edit', $article->id) }}">修改</a>
                            <a href="{{ url('admin/article/delete', $article->id) }}" onclick="return confirm('确定要删除当前文章吗?')">删除</a>
                            @if( $article->status == $Article::ARTICLE_STATUS_AUDIT)
                                <a href="{{ url('admin/article/publish', $article->id) }}" onclick="return confirm('确定发表当前文章吗？')">发表文章</a>
                            @elseif($article->status == $Article::ARTICLE_STATUS_PASS)
                                <a href="{{ url('admin/article/close', $article->id) }}" onclick="return confirm('确定发表当前文章吗？')">文章下架</a>
                            @elseif($article->status == $Article::ARTICLE_STATUS_CLOSE)
                                <a href="{{ url('admin/article/publish', $article->id) }}" onclick="return confirm('确定发表当前文章吗？')">重新上架</a>
                            @endif
                            <a href="{{ url('admin/article/showComment', $article->id) }}">查看评论</a>
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



            {{--<div class="page_list">--}}
                {{--<ul>--}}
                    {{--<li class="disabled"><a href="#">&laquo;</a></li>--}}
                    {{--<li class="active"><a href="#">1</a></li>--}}
                    {{--<li><a href="#">2</a></li>--}}
                    {{--<li><a href="#">3</a></li>--}}
                    {{--<li><a href="#">4</a></li>--}}
                    {{--<li><a href="#">5</a></li>--}}
                    {{--<li><a href="#">&raquo;</a></li>--}}
                {{--</ul>--}}
            {{--</div>--}}
        </div>
    </div>
</form>
<!--搜索结果页面 列表 结束-->



</body>
</html>