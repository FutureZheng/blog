<footer>
    <div class="main-footer">
        <div class="container">
            <div class="row footrow">
                <div class="col-md-3">
                    <div class="widget catebox">
                        <h4 class="title">分类目录</h4>
                        <div class="box category clearfix">
                            <ul>
                                @foreach( $categories as $category)
                                    <li class="cat-item cat-item-1">{{ $category->name }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="widget tagbox">
                        <h4 class="title">归档</h4>
                        <div class="box tags clearfix">
                            <ul class="post_tags">
                                <li></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="widget linkbox">
                        <h4 class="title">友情链接</h4>
                        <div class="box friend-links clearfix">
                            <ul>
                                @foreach($links as $link)
                                <li><a href="{{ $link->url }}" target="_blank">{{ $link->title }}</a></li>
                                 @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="widget contactbox">
                        <h4 class="title">联系我们</h4>
                        <div class="contact-us clearfix">
                            <ul>
                                <li><a href="tencent://message/?uin=&Site=&Meu=yes">
                                        <i class="fa fa-qq"></i>578472734</a></li>
                                <li><a href=""><i class="fa fa-weibo"></i>博主的微博</a></li>
                                {{--<script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1259246503'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s4.cnzz.com/stat.php%3Fid%3D1259246503%26show%3Dpic1' type='text/javascript'%3E%3C/script%3E"));</script>--}}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="copyright">
                    <span>Copyright &copy; By<a href="http://www.bananau.com" target="_blank">韵鸣</a>&nbsp;&nbsp;</span>
                    <span>Design by <a href="http://vinceok.com/" target="_blank">bug伦</a></span>
                    {{--<a href="tencent://message/?uin=&Site=&Meu=yes" class="kefu pull-right hidden-xs"><i class="fa fa-qq"></i>在线联系我</a>--}}
                    <a href="http://www.blog.com/tool/index/chat" class="kefu pull-right hidden-xs"><i class="fa fa-qq"></i>在线联系我</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- 菜单&侧边栏按钮 -->
<div class="menu mobile-menuicon hidden-lg hidden-md hidden-sm">
    <i class="fa fa-bars"></i>
</div>
<a class="to-top">
    <span class="topicon"><i class="fa fa-angle-up"></i></span>
    <span class="toptext">Top</span>
</a>
<div class="menubox">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <ul id="menu-menu" class="icon-list">
                    <li id="menu-item-170" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-170"></li>
                </ul>
                <ul id="menu-menu" class="icon-list">
                    <li class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-170"></li>
                </ul>
            </div>
        </div>
    </div>
    <a href="#" class="menu-close">&times;</a>
</div>

</body>
<script src="http://cdn.bootcss.com/jquery/2.1.1/jquery.min.js"></script>
<script src="{{ asset('js/jquery.toTop.min.js') }}"></script>
<script src="{{ asset('js/home/menu.js') }}"></script>
<script src="{{ asset('js/home/main.js') }}"></script>

<script type="text/javascript">
    $('.to-top').toTop({
        position:false,
        offset:1000
    });
</script>
</html>