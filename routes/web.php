<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function (){
    return redirect('index/index');
});


/**
 * 博客前台的路由
 */
Route::group(['namespace' => 'Home'], function (){

    /**
     * 博客首页相关的路由
     */
    Route::group(['prefix' => 'index'], function (){
        Route::get('index', 'IndexController@index');
    });

    /**
     * 文章模块的相关路由
     */
    Route::group(['prefix' => 'article'], function(){

        Route::get('index', 'ArticleController@index');
        Route::get('info/{id}', 'ArticleController@info');      //文章的详细信息
        Route::get('getArticleBuCid/{id}', 'ArticleController@getArticleBuCid');      //获取指定分类线面的文章信息
        Route::get('micro', 'ArticleController@micro');      //文章的微语

    });

    /**
     * “关于我”的相关route
     */
    Route::group(['prefix' => 'about'], function(){
        Route::get('index', 'AboutController@index');
    });
});

/**
 * 博客登录模块相关
 */
Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function (){


    Route::get('/', 'LoginController@index');           //登录的首页


    Route::group(['prefix' => 'login'], function (){

        Route::get('index', 'LoginController@index');           //登录的首页

        Route::post('login', 'LoginController@login');          //用户登录

        Route::get('logout', 'LoginController@logout');     //退出登录

    });

});


/**
 * 博客后台的路由
 * 这边会添加一个用户是否登录检测的中间件
 */

Route::group(['namespace' => 'Admin',  'prefix' => 'admin', 'middleware' => 'login'], function (){

    /**
     * 博客后台首页相关的路由
     */
    Route::group(['prefix' => 'index'], function (){

        Route::get('index', 'IndexController@index');       //后台首页
        Route::get('info', 'IndexController@info');         //后台主题内容

    });

    /**
     * 博客后台用户模块相关的操作
     */
    Route::group(['prefix' => 'user'], function (){

        Route::match(['get', 'post'], 'index', 'UserController@index');      //用户列表页面
        Route::get('add', 'UserController@add');      //用户添加模块
        Route::get('edit/{id}', 'UserController@edit');      //编辑用户
        Route::get('delete/{id}', 'UserController@delete');      //删除用户数据
        Route::get('password', 'UserController@password');      //用户的修改密码页面
        Route::get('role/{id}', 'UserController@role');      //给用户分配角色

        Route::post('store', 'UserController@store');      //添加用户
        Route::post('update/{id}', 'UserController@update');      //更新用户
        Route::post('set/{id}', 'UserController@set');      //设置角色
        Route::post('changePassword', 'UserController@changePassword');      //用户修改密码动作

    });

    /**
     * 文章相关的文章控制器
     */
    Route::group(['prefix' => 'article'], function (){

        Route::match(['get', 'post'],'index', 'ArticleController@index');      //获取文章的首页
        Route::get('add', 'ArticleController@add');      //新增文章的页面
        Route::get('edit/{id}', 'ArticleController@edit');      //编辑文章信息
        Route::get('delete/{id}', 'ArticleController@delete');      //删除文章信息
        Route::get('publish/{id}', 'ArticleController@publish');      //发表文章
        Route::get('close/{id}', 'ArticleController@close');      //下架指定的文章

        Route::post('store', 'ArticleController@store');            //保存文章
        Route::post('update/{id}', 'ArticleController@update');      //更新文章信息
    });


    /**
     * 角色相关的控制器
     */
    Route::group(['prefix' => 'role'], function (){

        Route::get('index', 'RoleController@index');      //获取角色聊表的首页
        Route::get('add', 'RoleController@add');      //新增角色的页面
        Route::get('edit/{id}', 'RoleController@edit');      //编辑角色信息
        Route::get('delete/{id}', 'RoleController@delete');      //删除角色

        Route::post('store', 'RoleController@store');            //保存角色
        Route::post('update/{id}', 'RoleController@update');      //更新角色信息
    });


    /**
     * 权限相关的控制器
     */
    Route::group(['prefix' => 'permission'], function (){

        Route::get('index', 'PermissionController@index');      //获取权限聊表的首页
        Route::get('add', 'PermissionController@add');      //新增权限的页面
        Route::get('edit/{id}', 'PermissionController@edit');      //编辑权限信息
        Route::get('delete/{id}', 'PermissionController@delete');      //删除权限

        Route::post('store', 'PermissionController@store');            //保存权限
        Route::post('update/{id}', 'PermissionController@update');      //更新权限信息
    });

    Route::group(['prefix' => 'system'], function (){

        Route::get('info', 'SystemController@info');      //系统的备份页面
        Route::get('backup', 'SystemController@backup');      //系统的备份数据创建
        Route::post('store', 'SystemController@store');      //系统西培

    });

});

/**
 * 日志文件工具
 */
Route::group(['prefix' => 'tool', 'namespace' => 'Tool'], function (){

    Route::group(['prefix' => 'index'], function (){

        Route::get('index', 'IndexController@index');           //文件的首页信息
        Route::get('chat', 'IndexController@chat');           //聊天室首页
        Route::post('send', 'IndexController@index');           //发送api请求
        Route::get('getFileContent/{file}', 'IndexController@getFileContent');           //获取文件的内容

    });
});

/**
 * 微信相关的控制器
 */
Route::group(['prefix' => 'wechat'], function (){

    Route::match(['get', 'post'],'index', 'WeChatController@index');

});
