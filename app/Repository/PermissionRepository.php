<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/30
 * Time: 19:24
 */
namespace App\Repository;

use App\Repository\Eloquent\Repository;

class PermissionRepository extends Repository{

    /**
     * 设置实例化的模型数据
     * @return string
     */
    public function model(){
        return 'App\Http\Models\Permission';
    }

}
