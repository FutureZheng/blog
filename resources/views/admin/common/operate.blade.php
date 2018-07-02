<!--结果集标题与导航组件 开始-->
<div class="result_wrap">
    <div class="result_title">
        <h3>快捷操作</h3>
    </div>
    <div class="result_content">
        <div class="short_wrap">
            <a href="{{ url('admin/article/index') }}"><i class="fa fa-compress"></i>文章列表</a>
            <a href="{{ url('admin/article/add') }}"><i class="fa fa-plus"></i>新增文章</a>
            <a href="{{ url('admin/article/delete', 'asc') }}"><i class="fa fa-recycle"></i>批量删除</a>
            <a href="{{ url('admin/article/index', 'asc') }}"><i class="fa fa-refresh"></i>更新排序</a>
        </div>
    </div>
</div>
<!--结果集标题与导航组件 结束-->