<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * 用户表的模型
 * Date: 2017/8/10
 * Time: 12:59
 */
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model {

    /**
     * 定义主键
     * @var string
     */
    protected $primaryKey = 'id';


    /**
     * 开启自动维护时间错
     * @var bool
     */
    public $timestamps = true;

    /**
     * 设置可以批量赋值的属性
     * @var array
     */
    protected $fillable = ['username', 'email', 'password'];

    /**
     * 定义一个用户的权限数组
     * @var array
     */
    public static $user_accesses = [];

    /**
     * 自动填充unix时间戳
     * @return int
     */
    public function getDateFormat(){
        return time();
    }

    /**
     * 加密用户密码
     * @param string $password  用户密码
     * @return bool|string
     */
    public static function _encryptPassword($password){
        $crypt = md5($password);
        return password_hash($crypt, PASSWORD_DEFAULT);
    }

    /**
     * 解密用户密码
     * @param string $password  用户密码
     * @param string $hash  用户密码的hash值
     * @return bool
     */
    public static function _decryptPassword($password, $hash){
        $crypt = md5($password);
        return password_verify($crypt, $hash);
    }

    /**
     * 获取用户保存在session当中的洪湖信息
     * @return mixed
     */
    public static function getUserInfoBuSession(){
        $user = session('user');
        return $user;
    }

    /**
     * 设置用户的信息
     * @param object $user  用户信息
     */
    public static function setUserInfoBySession($user){
        session(['user' => $user]);
    }
}