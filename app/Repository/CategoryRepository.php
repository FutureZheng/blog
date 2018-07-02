<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/30
 * Time: 19:24
 */
namespace App\Repository;

use App\Repository\Eloquent\Repository;

class CategoryRepository extends Repository{

    /**
     * 设置实例化的模型数据
     * @return string
     */
    public function model(){
        return 'App\Http\Models\Category';
    }

    /**
     * 获取无限极分类树
     * @return array
     */
    public function getCategoryTree(){
        return self::getClassifyTree($this->selectAll()->toArray());
    }

    /**
     * 根据分类id获取分类的名称
     * @param $id
     * @return bool
     */
    public function getCategoryNameById($id){
        if ( !$id ){
            return false;
        }
        return $this->model->where('id', $id)->value('name');
    }

    /**
     * 无限极分类
     * @param array $categories     二位属猪
     * @param int $level            当前查询的层级
     * @param int $pid              父类id
     * @return array
     */
    public static function getClassifyTree(array $categories, $level = 1, $pid = 0){
        static $tree = array();

        foreach ( $categories as $category ){
            if ( $category['pid'] == $pid ){
                $category['level'] = $level;
                $tree[] = $category;
                self::getClassifyTree($categories, $level = $level + 1, $category['id']);
            }
        }
        return $tree;
    }

    /**
     * 获取文章的分类名称
     * @param $articles
     * @return mixed
     */
    public function getCategoryName($articles){
        //定义一个数组
        $data = array();
        foreach ( $articles as &$article ){
            if ( isset($data[$article->cid]) ){
                $article->name = $data[$article->cid];
            }else{
                $category = $this->where('id', $article->cid)->first(['id', 'name']);
                $data[$category->id] = $category->name;
                $article->name = $category->name;
            }
        }
        unset($data);
        return $articles;
    }
}
