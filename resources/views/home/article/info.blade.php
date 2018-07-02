@include('home.common.header')
<!-- 主体内容 -->
<div class="articleDetail container">
    <div class="row">
        <div class="col-md-12">
            <div class="articleContent">
                <!-- 标题 -->
                <div class="title">
                    {{ $article->title }}
                </div>
                <!-- 访问量 ...-->
                <div class="secTitleBar">
                    <ul>
                        <li>分类：{{ $CategoryRepository->getCategoryNameById($article->cid) }}</li>
                        <li>发表：{{ $article->publish_at }}</li>
                        <li>作者：{{ $article->author }}</li>
                        {{--<li><a href="#comments">评论()</a></li>--}}
                    </ul>
                </div>
                <!-- 内容 -->
                <div class="articleCon post_content">
                    {!! html_entity_decode($article->content, ENT_HTML401, 'UTF-8') !!}
                </div>
                <!-- 标签 -->
                <div class="articleTagsBox">
                    <ul><span>标签：@if($tags){{ implode(',', $tags) }}@endif</span></ul>
                </div>

                <!-- 评论 -->
                <div class="post_content">
                    <a name="comments"></a>
                    <div class="ds-thread" data-thread-key="" data-title="" data-url=""></div>

                    <div id="ds-ssr">
                        <ol id="commentlist"></ol>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@include('home.common.footer')