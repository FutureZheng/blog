<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/30
 * Time: 19:24
 */
namespace App\Repository;

use App\Repository\Eloquent\Repository;

class ArticleRepository extends Repository{

    /**
     * 文章的状态
     */
    const ARTICLE_STATUS_AUDIT = 0;
    const ARTICLE_STATUS_PASS = 1;
    const ARTICLE_STATUS_CLOSE = 2;

    /**
     * 是否为博主推荐文章
     */
    const IS_RECOMMEND_FALSE = 0;
    const IS_RECOMMEND_TRUE = 1;

    /**
     * 文章是否是新文章
     */
    const IS_NEW_FALSE = 0;
    const IS_NEW_TRUE = 1;

    /**
     * 文章状态数组
     */
    const ARTICLE_STATUS_ARRAY = [
        self::ARTICLE_STATUS_AUDIT => '审核中',
        self::ARTICLE_STATUS_PASS => '文章发表',
        self::ARTICLE_STATUS_CLOSE => '文章下架',
    ];

    /**
     * 是否为博主推荐文章数组
     */
    const ATRICLE_IS_RECOMAND = [
        self::IS_RECOMMEND_FALSE => '不是',
        self::IS_RECOMMEND_TRUE => '是',
    ];

    /**
     * 获取文章的状态信息
     * @param $status
     * @return bool|mixed
     */
    public function getArticleStatus($status){
        if ( !array_key_exists($status, self::ARTICLE_STATUS_ARRAY) ){
            return false;
        }
        return self::ARTICLE_STATUS_ARRAY[$status];
    }

    /**
     * 获取文章的状态信息
     * @param $status
     * @return bool|mixed
     */
    public function getArticleIsRecommend($status){
        if ( !array_key_exists($status, self::ATRICLE_IS_RECOMAND) ){
            return false;
        }
        return self::ATRICLE_IS_RECOMAND[$status];
    }

    /**
     * 设置实例化的模型数据
     * @return string
     */
    public function model(){
        return 'App\Http\Models\Article';
    }

    /**
     * 获取博主推荐文章
     * @param int $pageSize
     * @return mixed
     */
    public function getRecommendArticles($pageSize = self::DEFAULT_PAGE_SIZE){
        return $this->paginate(['id', 'cid', 'title', 'description', 'author', 'image', 'number', 'created_at'], [
            ['status', '=', self::ARTICLE_STATUS_PASS],
            ['is_recommend', '=', self::IS_RECOMMEND_TRUE],
        ]);
    }

    /**
     * 获取最新文章
     * @param int $pageSize
     * @return mixed
     */
    public function getNewArticles($pageSize = self::DEFAULT_PAGE_SIZE){
        return $this->limit($pageSize)->where([
            ['status', '=', self::ARTICLE_STATUS_PASS],
            ['is_new', '=', self::IS_NEW_TRUE],
        ])->get(['id', 'title']);
    }

    /**
     * @param int $pageSize
     * @return mixed
     */
    public function getClickArticles($pageSize = self::DEFAULT_PAGE_SIZE){
        return $this->limit($pageSize)->where('status', '=', self::ARTICLE_STATUS_PASS)->orderBy('number', 'desc')->get(['id', 'title']);
    }

    /**
     * 获取指定条件的文章数据
     * @param array $search
     * @param string $orderBy
     * @return mixed
     */
    public function getArticleList($search = array(), $orderBy = 'desc'){
        return $this->model->when(is_numeric($search['status']), function ($query) use ($search){
            return $query->where('status', $search['status']);
        })->when($search['key'] && $search['keywords'], function ($query) use ($search){
            return $query->where($search['key'], 'like', '%'.$search['keywords'].'%');
        })->orderBy('id', $orderBy)->paginate();
    }

    /**
     * 根据指定的id获取审核通过的文章
     * @param $id
     * @return bool
     */
    public function getPassArticle($id){
        return $this->findWhere([['id', '=', $id], ['status', '=', self::ARTICLE_STATUS_PASS]]);
    }

    /**
     * 发表指定的文章
     * @param $user_id
     * @param $id
     * @return mixed
     */
    public function publishArticle($user_id, $id){
        return $this->update([
            'audit_admin_id' => $user_id,
            'is_recommend' => self::IS_RECOMMEND_TRUE,
            'audit_at' => get_time(),
            'updated_at' => get_time(),
            'status' => self::ARTICLE_STATUS_PASS
        ], $id);
    }

    /**
     * 下架指定的文章
     * @param $id
     * @return mixed
     */
    public function closeArticle($id){
        return $this->update(['status' => self::ARTICLE_STATUS_CLOSE], $id);
    }

}
