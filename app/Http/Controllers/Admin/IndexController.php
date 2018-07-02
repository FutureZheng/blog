<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Base\BaseAdminController;

class IndexController extends BaseAdminController
{
    /*
     * 后台的首页
     */
    public function index(){
        return view('admin.index.index');
    }

    /**
     * 获取用户的权限列表
     */
    public function getMenuList(){}

    /**
     * 中间的主题内容
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function info(){
        return view('admin.index.info');
    }

}
