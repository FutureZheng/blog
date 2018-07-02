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
    <i class="fa fa-home"></i> <a href="#">首页</a> &raquo; <a href="{{ url('admin/article/index') }}">文章管理</a> &raquo; 编辑文章
</div>
<!--面包屑导航 结束-->

{{--快捷操作--}}
<div class="result_wrap">
    <div class="result_title">
        <h3>快捷操作</h3>
    </div>
    <div class="result_content">
        <div class="short_wrap">
            <a href="{{ url('admin/article/index') }}"><i class="fa fa-compress"></i>文章列表</a>
            <a href="{{ url('admin/article/add') }}"><i class="fa fa-plus"></i>新增文章</a>
        </div>
    </div>
</div>

<div class="result_wrap">
    <form action="{{ url('admin/article/update', $article->id) }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <table class="add_tab">
            <tbody>
            <tr>
                <th width="120"><i class="require">*</i>分类：</th>
                <td>
                    <select name="cid">
                        <option>--请选择--</option>
                        @foreach( $categories as $category)
                            {{--这边添加了分类筛选的勾选问题--}}
                            <option value="{{ $category['id'] }}" @if($article->cid == $category['id']) selected='selected'@endif>{{ str_pad($category['name'], strlen($category['name']) + $category['level'], '--', STR_PAD_LEFT) }}</option>
                        @endforeach
                    </select>
                    <i>{{ $errors->first('cid') }}</i>
                </td>
            </tr>
            <tr>
                <th>文章的标签：</th>
                <td>
                    @foreach( $tags as $tag)
                        <label for=""><input type="checkbox" @if(in_array($tag->id, $article_tags)) checked="checked" @endif  value="{{ $tag->id }}" name="tags[]">{{ $tag->name }}</label>
                    @endforeach
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i>标题：</th>
                <td>
                    <input type="text" class="lg" name="title" value="{{ $article->title }}" placeholder="标题可以写30个字">
                    <i>{{ $errors->first('title') }}</i>
                    {{--<p>标题可以写30个字</p>--}}
                </td>
            </tr>
            <tr>
                <th>作者：</th>
                <td>
                    <input type="text" name="author" value="{{ $article->author }}" placeholder="请输入文章的作者">
                    <span><i class="fa fa-exclamation-circle yellow"></i>这里是默认长度</span>
                </td>
            </tr>
            <tr>
                <th><i class="require">*</i>缩略图：</th>
                <td><input type="file" name="photo"></td>
            </tr>
            <tr>
                <th>是否为博主推荐：</th>
                <td>
                    <label for=""><input type="radio" value="1" @if( $article->is_recommend == 1 )checked="checked"  @endif name="is_recommend">是</label>
                    <label for=""><input type="radio" value="0" @if( $article->is_recommend == 0 )checked="checked"  @endif name="is_recommend">不是</label>
                </td>
            </tr>
            <tr>
                <th>描述：</th>
                <td>
                    <textarea name="description" placeholder="情输入文章的描述信息">{{ $article->description }}</textarea>
                </td>
            </tr>
            <tr>
                <th>详细内容：</th>
                <td>
                    <textarea style="height: 300px; width: 1000px" class="lg" id="content" name="content">{{ $article->content }}</textarea>
                    {{--<p>标题可以写30个字</p>--}}
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
<script type="text/javascript" src="{{ asset('js/nicEdit.js') }}"></script>
<script type="text/javascript">
    new nicEditor({fullPanel : true}).panelInstance('content');
</script>