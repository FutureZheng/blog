<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Base\BaseHomeController;
use App\Repository\ArticleRepository as Article;
use App\Repository\CategoryRepository;
use App\Repository\TagRepository;

class IndexController extends BaseHomeController
{
    private $article;
    private $category;
    private $tag;

    /**
     * IndexController constructor.
     * @param Article $article
     * @param CategoryRepository $category
     * @param TagRepository $tag
     */
    public function __construct(Article $article, CategoryRepository $category, TagRepository $tag){
        $this->article = $article;
        $this->category = $category;
        $this->tag = $tag;
    }

    /**
     * 前台的首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){

        //获取推荐文章
        $articles = $this->category->getCategoryName($this->article->getRecommendArticles());

        //TODO 获取文章的标签信息
        return view('home.index.index', [
            'articles' => $articles
        ]);
    }
}
