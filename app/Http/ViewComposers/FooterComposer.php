<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * 创建了一个视图合成器
 * Date: 2017/11/15
 * Time: 9:55
 */
namespace App\Http\ViewComposers;

use App\Repository\CategoryRepository;
use App\Repository\FriendLinkRepository;
use Illuminate\View\View;

class FooterComposer{

    /**
     * @var CategoryRepository
     */
    private $category;

    /**
     * @var FriendLinkRepository
     */
    private $links;

    /**
     * FooterComposer constructor.
     * @param CategoryRepository $category
     * @param FriendLinkRepository $links
     */
    public function __construct(CategoryRepository $category, FriendLinkRepository $links){
        $this->category = $category;
        $this->links = $links;
    }

    /**
     * 绑定数据到视图里面
     * @param View $view
     */
    public function compose(View $view){

        //分类目录
        $categories = $this->category->where('pid', 0)->get(['name']);

        //友情链接
        $links = $this->links->getFriendLinks();

        /**
         * 分配数据到指定的模板里面
         */
        $view->with('categories', $categories)
            ->with('links', $links);
    }
}