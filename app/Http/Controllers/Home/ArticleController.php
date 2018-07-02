<?php
/**
 * Created by PhpStorm.
 * User: hasee
 * Date: 2017/11/5
 * Time: 22:54
 */
namespace App\Http\Controllers\Home;

use App\Http\Controllers\Base\BaseHomeController;
use App\Repository\ArticleAndTagRepository;
use App\Repository\ArticleRepository as Article;
use App\Repository\CategoryRepository;
use App\Repository\TagRepository;

class ArticleController extends BaseHomeController{

    private $article = null;
    private $tag = null;
    private $article_and_tag = null;
    private $categoryRepository = null;

    /**
     * ArticleController constructor.
     * @param Article $article
     * @param TagRepository $tag
     * @param ArticleAndTagRepository $article_and_tag
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(Article $article, TagRepository $tag, ArticleAndTagRepository $article_and_tag, CategoryRepository $categoryRepository){
        $this->article = $article;
        $this->tag = $tag;
        $this->article_and_tag = $article_and_tag;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * 获取文章的首页
     * @return mixed
     */
    public function index(){
        return view('home/article/index');
    }

    /**
     * 获取文章详情
     * @param $id
     * @return mixed
     */
    public function info($id){
        //查询文章的信息
        $article = $this->article->find($id);
        if ( !$article ){
            //TODO 当前文章已经不存在，跳转到404页面，发送邮件告知管理员
        }

        //获取文章的标签信息
        $tag_id = $this->article_and_tag->where('article_id', $id)->pluck('tag_id');

        //获取文章的标签信息
        $tags = $this->tag->whereIn('id', $tag_id)->pluck('name')->toArray();

        //记录文章的访问次数
        $this->article->update(['number' => $article->number + 1], $id);
        return view('home/article/info', [
            'article' => $article,
            'tags' => $tags,
            'CategoryRepository' => $this->categoryRepository
        ]);
    }

    /**
     * 获取文章的列表信息
     * @param $cid
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getArticleBuCid($cid){
        $articles = $this->article->where('cid', $cid)->get();

        return view('home.article.index', [
            'articles' => $articles
        ]);
    }

    public function micro(){
        return view('home.article.micro');
    }
}