@include('home.common.header')

<!-- 主体文章 -->
@if( $articles->isNotEmpty() )
@foreach( $articles as $article)
<div class="articleList container">
    <div class="row">
        <div class="col-md-12">
            <!--single article-->
            <div class="article">
                <div class="articleHeader">
                     {{--这边添加 文章详情的url 文章的标题信息--}}
                    <h1 class="articleTitle"><a href="{{ url('article/info', $article->id) }}">{{ $article->title }}</a></h1>
                </div>
                <div class="articleBody clearfix">
                    <!--缩略图-->
                    <div class="articleThumb">
                         {{--这边填写文章的缩略图url--}}
                        <a href=" "><img src="{{ asset('uploads/'.$article->image) }}" alt="{{ $article->titile }}" class="wp-post-image" width="400" height="200"  /></a>
                    </div>
                    <!--摘要-->
                    <div class="articleFeed">
                        {{ $article->description }}
                    </div>
                    <!--tags-->
                    <div class="articleTags">
                        <ul></ul>
                    </div>
                </div>
                <div class="articleFooter clearfix">
                    <ul class="articleStatu">
                        <li><i class="fa fa-calendar"></i>{{ $article->created_at }}</li>
                        <li><i class="fa fa-eye"></i>{{ $article->number }}次浏览</li>
                        <li><a href=""><i class="fa fa-folder-o"></i>{{ $article->name }}</a></li>
                    </ul>
                    <a href="{{ url('article/info', $article->id) }}" class="btn btn-readmore btn-info btn-md">阅读更多</a>
                </div>
            </div>
            <!--single article-->
            <!--single article-->
        </div>
    </div>
</div>
<!--footer-->
@endforeach
@else
<div class="articleList container">
    <p>抱歉，没有符合您查询条件的结果。</p>
</div>
@endif

<div class="container pageNav">
    <div class="row">
        <div class="col-md-12">
            <ul class="pagination">
                <li class="page-numbers"></li>
            </ul>
        </div>
    </div>
</div>
@include('home.common.footer')