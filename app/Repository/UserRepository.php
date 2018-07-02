<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/30
 * Time: 19:24
 */
namespace App\Repository;

use App\Repository\Eloquent\Repository;

class UserRepository extends Repository{

    /**
     * 用户的状态
     */
    const STATUS_NORMAL = 1;

    /**
     * 是否是管理员
     */
    const IS_ADMIN_TRUE = 1;
    const IS_ADMIN_FALSE = 0;

    /**
     * 用户的权限
     */
    public $user_access = [];

    /**
     * 状态的数组敞亮
     * @var array
     */
    private $user_status_array = array(
        self::STATUS_NORMAL => '正常'
    );

    /**
     * 是狗是管理员
     * Description:
     * @var array
     */
    private  $is_admin_array = [
        self::IS_ADMIN_TRUE => '是',
        self::IS_ADMIN_FALSE => '否',
    ];

    /**
     * 设置实例化的模型数据
     * @return string
     */
    public function model(){
        return 'App\Http\Models\User';
    }

    /**
     * 根据用户的状态获取用户的状态值
     * @param integer $status   用户的状态
     * @return bool|mixed
     */
    public function getStatusMessage( $status ){
        if ( !array_key_exists($status, $this->user_status_array)){
            return false;
        }
        return $this->user_status_array[$status];
    }

    /**
     * 获取用户是否是管理员的状态信息
     * @param $is_admin
     * @return array|mixed
     */
    public function getIsAdminMessage( $is_admin ){
        if ( !array_key_exists($is_admin, $this->is_admin_array)){
            return false;
        }
        return $this->is_admin_array[$is_admin];
    }

    /**
     * 通过session获取用户的信息
     * @return bool|mixed
     */
    public function getUserInfoBySession(){
        if ( !$userInfo = session('user') ){
            return false;
        }
        return $userInfo;
    }

    /**
     * 设置用户的session数值
     * @param $value
     */
    public function setUserInfoToSession($value){
        session(['user' => $value]);
    }

    /**
     * 根据用户id获取用户的信息
     * @param $id
     * @return mixed
     */
    public function getUserNameById($id){
        return $this->model->where('id', $id)->value('username');
    }

    /**
     * 根据指定的条件去查询用户的信息
     * @param array $search
     * @param string $orderBy
     * @return mixed
     */
    public function getUserList($search = array(), $orderBy = 'desc'){
        return $this->model->when($search['condition'] && $search['keywords'], function ($query) use ($search){
            return $query->where($search['condition'], 'like', '%'.$search['keywords'].'%');
        })->orderBy('id', $orderBy)->paginate(self::DEFAULT_PAGE_SIZE, ['id', 'username', 'email', 'status', 'is_admin', 'login_ip', 'login_at']);
    }
}
