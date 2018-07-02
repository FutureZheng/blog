<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/30
 * Time: 19:09
 */
namespace App\Repository\Eloquent;

use App\Repository\Contracts\RepositoryInterface;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Model;

abstract class Repository implements RepositoryInterface{

    const DEFAULT_PAGE_SIZE = 15;

    /**
     * 应用容器信息
     * @var Container|null
     */
    private $container = null;

    /**
     * 当前的模型信息
     * @var null
     */
    protected $model = null;

    /**
     * 抽象方法，获取对应的模型
     * @return mixed
     */
    abstract function model();

    /**
     * 创建容器
     * Repository constructor.
     * @param Container $container
     */
    public function __construct(Container $container){
        $this->container = $container;
        $this->getInstance();
    }

    /**
     * 获取实例的模型信息
     * @return mixed|null
     */
    public function getInstance(){

        $this->model = $this->container->make($this->model());

        if ( $this->model instanceof Model){
            //TODO 抛出异常
        }

        return $this->model;
    }

    /**
     * 获取用户的单条数据
     * @param integer $id   用户的id
     * @param array $columns    查询的字段
     * @return mixed
     */
    public function find($id, $columns = array('*')){
        return $this->model->find($id, $columns);
    }

    /**
     * 根据指定条件查询
     * @param $value
     * @param $callback
     * @param null $default
     * @return mixed
     */
    public function when($value, $callback, $default = null){
        return $this->model->when($value, $callback, $default);
    }

    /**
     * 查询多条记录信息
     * @param array $columns
     * @param null $column
     * @param null $value
     * @param string $operator
     * @return mixed
     */
    public function selectAll($columns = array('*'), $column = null, $value = null, $operator = '='){
        if ( !$column ) {
            return $this->model->get($columns);
        }

        if ( is_array($column) ){
            return $this->model->where($column)->get($columns);
        }

        return $this->model->where($column, $operator, $value)->get($columns);
    }

    /**
     * @param array $columns
     * @return mixed
     */
    public function get($columns = ['*']){
        return $this->model->get($columns);
    }

    /**
     * @param $column
     * @param null $operator
     * @param null $value
     * @return mixed
     */
    public function orWhere($column, $operator = null, $value = null)
    {
        return $this->model->where($column, $operator, $value, 'or');
    }

    /**
     * 查询单条的记录信息
     * @param $column
     * @param null $key
     * @return mixed
     */
    public function pluck($column, $key = null){
        return $this->model->pluck($column, $key);
    }

    /**
     * @param $value
     * @return mixed
     */
    public function limit($value){
        return $this->model->limit($value);
    }

    /**
     * 排序规则
     * @param $column
     * @param string $direction
     * @return mixed
     */
    public function orderBy($column, $direction = 'desc'){
        return $this->model->orderBy($column, $direction);
    }

    /**
     * 可以根据指定的条件进行分页，也可以只分页
     * @param array $columns
     * @param null $column
     * @param int $perPage
     * @param null $value
     * @param string $operator
     * @return mixed
     */
    public function paginate($columns = ['*'], $column = null, $value = null, $operator = '=', $perPage = self::DEFAULT_PAGE_SIZE) {
        if ( !$column ) {
            return $this->model->paginate($perPage, $columns);
        }
        if ( is_array($column) ){
            return $this->model->where($column)->paginate($perPage, $columns);
        }

        return $this->model->where($column, $operator, $value)->paginate($perPage, $columns);
    }

    /**
     * 根据数据表id来更新数据
     * @param array $data   需要更新的数据
     * @param integer $id       数据表id
     * @param string $attribute 字段名
     * @return mixed
     */
    public function update(array $data, $id, $attribute="id") {
        return $this->model->where($attribute, '=', $id)->update($data);
    }

    /**
     * 查询指定条件
     * @param $column
     * @param null $operator
     * @param null $value
     * @param string $boolean
     * @return mixed
     */
    public function where($column, $operator = null, $value = null, $boolean = 'and'){
        return $this->model->where($column, $operator, $value, $boolean);
    }

    /**
     * 根据指定指端，查询单条数据
     * @param $attribute
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($attribute, $value, $columns = ['*']) {

        if ( !$attribute ){
            return false;
        }
        return $this->model->where($attribute, '=', $value)->first($columns);
    }

    /**
     * 根据指定指端，查询单条数据
     * @param $attribute
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function getBy($value, $attribute = 'id', $operate = '=', $columns = ['*']) {

        if ( !$value ){
            return false;
        }
        return $this->model->where($attribute, $operate, $value)->first($columns);
    }

    /**
     * 获取单个数值value
     * @param string $column
     * @return mixed
     */
    public function value($column){
        return $this->model->value($column);
    }

    /**
     * 根据多个条件查询信息
     * @param $where
     * @param array $columns
     * @return bool
     */
    public function findWhere($where, $columns = ['*']){
        if ( !$where ){
            return false;
        }
        if ( !is_array($where)){
            return false;
        }
        return $this->model->where($where)->get($columns);
    }

    /**
     * 根据指定的条件查询列表数据
     * @param $value
     * @param string $where
     * @param array $columns
     * @return bool
     */
    public function getIn($value, $where = 'id', $columns = ['*']){
        if ( !$value ){
            return false;
        }
        return $this->model->whereIn($where, $value)->get($columns);
    }

    /**
     * 根据指定的条件查询单条数据数据
     * @param $value
     * @param string $where
     * @param array $columns
     * @return bool
     */
    public function findIn($value, $where = 'id', $columns = ['*']){
        if ( !$value ){
            return false;
        }
        return $this->model->whereIn($where, $value)->first($columns);
    }

    /**
     * 添加记录
     * @param array $data
     * @return mixed
     */
    public function insert( array  $data){
        return $this->model->insert($data);
    }

    /**
     * 插入数据的同时，获取id
     * @param array $values
     * @param null $sequence
     * @return mixed
     */
    public function insertGetId(array $values, $sequence = null){
        return $this->model->insertGetId($values, $sequence);
    }

    /**
     * 指定删除的条件
     * @param $column
     * @param $values
     * @param string $boolean
     * @param bool $not
     * @return mixed
     */
    public function whereIn($column, $values, $boolean = 'and', $not = false){
        return $this->model->whereIn($column, $values, $boolean, $not);
    }

    /**
     * 根据不同的条件删除指定的数据
     * @param $id
     * @param string $column
     * @param string $operator
     * @return bool
     */
    public function delete($id, $column = 'id', $operator = '=') {
        if (!$id){
            return false;
        }
        if (is_array($id)){
            return $this->model->whereIn($column, $id)->delete();
        }
        return $this->model->where($column, $operator, $id)->delete();
    }

}