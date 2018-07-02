<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Base\BaseAdminController;
use App\Http\Middleware\EncryptCookies;
use App\Http\Requests\Admin\Article\StoreRequest;
use App\Http\Requests\Admin\ArticleRequest;
use App\Repository\ArticleAndTagRepository;
use App\Repository\ArticleRepository as Article;
use App\Repository\CategoryRepository as Category;
use App\Repository\TagRepository;
use App\Repository\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends BaseAdminController
{
    private $article;
    private $category;
    private $tag;
    private $article_and_tag;
    private $userRepository;

    /**
     * 实例化对应的文章仓库信息
     * ArticleController constructor.
     * @param Article $article
     * @param Category $category
     * @param TagRepository $tag
     * @param ArticleAndTagRepository $article_and_tag
     * @param UserRepository $userRepository
     */
    public function __construct(Article $article, Category $category, TagRepository $tag, ArticleAndTagRepository $article_and_tag, UserRepository $userRepository){
        $this->article = $article;
        $this->category = $category;
        $this->tag = $tag;
        $this->article_and_tag = $article_and_tag;
        $this->userRepository = $userRepository;
    }

    /**
     * 显示文章的列表页面
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request){
        //获取请求的参数
        $data = $request->only('key', 'keywords', 'status');
        //查询记录信息
        $articles = $this->article->getArticleList($data);
        return view('admin.article.index', [
            'articles' => $articles,
            'search' => $data,
            'Article' => $this->article,
            'UserRepository' => $this->userRepository
        ]);
    }

    /**
     * 文章列表的添加页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add(){

        $categories = $this->category->getCategoryTree();

        $tags = $this->tag->selectAll(['id', 'name']);

        return view('admin.article.add', [
            'categories' => $categories,
            'tags' => $tags
        ]);
    }

    /**
     * 根据id更新审核中的文章信息
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function publish($id){
        //获取审核中的文章
        $article = $this->article->find($id);
        if ( !$article ){
            return back()->with(['message' => '文章不存在']);
        }
        //发布文章
        //获取当前登录用户的信息
        $userInfo = $this->userRepository->getUserInfoBySession();
        $this->article->publishArticle($userInfo->id, $article->id);

        return redirect('admin/article/index')->with('message', '文章发布成功');
    }

    /**
     * 下架指定的文章
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function close($id){
        //获取审核通过的文章
        $article = $this->article->getPassArticle($id);
        if ( !$article ){
            return back()->with(['message' => '文章不存在']);
        }
        if ( !$this->article->closeArticle($article->id) ){
            return redirect('admin/article/index')->with('message', '操作失败');
        }
        return redirect('admin/article/index')->with('message', '操作成功');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        //
    }

    /**
     * 添加文章信息
     * @param ArticleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ArticleRequest $request){

        //添加文章的信息
        $data = $request->only('cid', 'title', 'author', 'description', 'is_recommend');
        $content = htmlspecialchars($request->input('content'));

        /**
         * 判断文件是否上传
         */
        $file = $request->file('photo');
        if ( !$file || !$file->isValid() ){
            return back()->withInput($request->all())->with(['message' => '文件缩略图没有上传~']);
        }
        $path = $request->file('photo')->store('article', 'uploads');

        //添加文章的内容
        $id = $this->article->insertGetId(array_merge($data,array(
            'content' => $content,
            'image' => $path,
            'publish_at' => get_time(),
            'edit_at' => get_time(),
            'audit_at' => get_time(),
            'created_at' => get_time(),
            'updated_at' => get_time()
        )));

        if ( $request->has('tags') ){
            foreach ( $request->input('tags') as $tag){
                $this->article_and_tag->insert(['article_id' => $id, 'tag_id' => $tag, 'created_at' => get_time()]);
            }
        }   //添加文章标签

        return redirect('admin/article/index')->with('message', '文章编辑成功!!');
    }

    /**
     * Display the specified resource.
     * 文章详情信息
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        //获取文章的分类
        $categories = $this->category->getCategoryTree();

        //获取文章信息
        $article = $this->article->find($id);

        //获取所有的标签信息
        $tags = $this->tag->selectAll(['id', 'name']);

        //获取文章的标签信息
        $article_tags = $this->article_and_tag->where('article_id', $id)->pluck('tag_id')->toArray();

        return view('admin/article/edit', [
            'categories' => $categories,
            'article' => $article,
            'tags' => $tags,
            'article_tags' => $article_tags
        ]);
    }

    /**
     *
     * @param ArticleRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ArticleRequest $request, $id){

        //添加文章的信息
        $data = $request->only('cid', 'title', 'author', 'description', 'is_recommend');
        $content = htmlspecialchars($request->input('content'));

        /**
         * 判断文件是否上传
         */
        $file = $request->file('photo');
        if ( $file && $file->isValid() ){
            $path = $request->file('photo')->store('article', 'uploads');
            $data['image'] = $path;
        }       //如果图片有上传，则更新图片的路径信息

        //更新用户的巨鹿
        $this->article->where('id', $id)->update(array_merge($data, array(
            'content' => $content,
            'audit_at' => get_time(),
            'updated_at' => get_time()
        )));

        if ( $tags = $request->input('tags') ){

            //计算传递过来的文章标签数组
            $article_tags = $this->article_and_tag->where('article_id', $id)->pluck('tag_id')->toArray();

            //计算需要删除的标签
            $delete_tags = array_diff($article_tags, $tags);
            if ( $delete_tags ){
                $this->article_and_tag->where('article_id', $id)->delete($delete_tags);
            }

            //计算需要添加的数组
            $insert_tags = array_diff($tags, $article_tags);
            if ( $insert_tags){
                foreach ( $insert_tags as $insert_tag){
                    $this->article_and_tag->insert(['article_id' => $id, 'tag_id' => $insert_tag, 'created_at' => get_time()]);
                }
            }
        }

        return redirect('admin/article/index')->with('message', '文章编辑成功!!');
    }

    /**
     * Remove the specified resource from storage.
     * 根据文章id删除文章信息
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id){
        $article = $this->article->find($id);
        if ( !$article ){
            return redirect('admin/article/index')->with('message', '文章'.$article->id.'不存在');
        }

        if ( !$this->article->delete($article->id) ){
            return redirect('admin/article/index')->with('message', '文章'.$article->id.'删除失败');
        }
        return redirect('admin/article/index')->with('message','文章'.$article->id.'删除成功!!!');
    }
}
