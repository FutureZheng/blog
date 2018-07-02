<?php

namespace App\Http\Middleware;

use App\Events\LogEvent;
use App\Repository\PermissionRepository as Permission;
use App\Repository\RoleAndPermissionRepository as RoleAndPermission;
use App\Repository\UserAndRoleRepository as UserAndRole;
use App\Repository\UserRepository as User;
use Closure;

class CheckLogin
{

    private $user = null;
    private $user_and_role = null;
    private $role_and_permission = null;
    private $permission = null;

    /**
     * 设置不用做权限验证的url
     * @var array
     */
    protected static $allow_url = [
        '/admin/login/index',
        '/admin/login/login',
        '/admin/login/logout'
    ];      //错误页面

    /**
     * 控制钱实例化
     * CheckLogin constructor.
     * @param User $user
     * @param UserAndRole $user_and_role
     * @param RoleAndPermission $role_and_permission
     * @param Permission $permission
     */
    public function __construct(User $user, UserAndRole $user_and_role, RoleAndPermission $role_and_permission, Permission $permission){
        $this->user = $user;
        $this->user_and_role = $user_and_role;
        $this->role_and_permission = $role_and_permission;
        $this->permission = $permission;
    }

    /**
     * Handle an incoming request.
     * 这边检测用户的权限
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //判断当前访问的url是否在允许访问的url列表里面
        $url = $request->getRequestUri();
        if ( !in_array($url, self::$allow_url)){
            $user = $this->user->getUserInfoBySession();
            if ( !$user ){
                return redirect('admin/login/index');
            }
            //记录用户的操作日志信息
            event(new LogEvent($request));

            if ( !$user->is_admin){     //如果不是超级管理员则进行权限的判断
                //获取用户的权限
                $user_permission = $this->user->user_access = $this->getUserAccess();
                //获取当前访问的uri
                $pathInfo = $request->getPathInfo();
                if ( !in_array($pathInfo, $user_permission)){
                    //TODO 无权限访问，显示无权限页面
                    echo '暂无权限';die;
                }
            }
        }

        return  $next($request);
    }

    /**
     * 获取用户的权限
     * @param integer $user_id
     * @return array
     */
    protected function getUserAccess($user_id = 0){
        $user_id = $user_id ? $user_id : $this->user->getUserInfoBySession()->id;
        $user_permission = array();
        //根据用户id来获取用户的所有角色id
        $user_and_roles = $this->user_and_role->where([['status', '=', 1], ['user_id', '=', $user_id],])->pluck('role_id');
        if ( $user_and_roles ){
            //定义一个数组，获取每一个角色下面对应的权限
            $role_and_permission = $this->role_and_permission->where('status', '=', 1)->whereIn('role_id', $user_and_roles)->pluck('permission_id');
            if ( $role_and_permission ){
                $permissions = $this->permission->whereIn('id', $role_and_permission)->pluck('url');

                foreach ( $permissions as $permission){
                    $user_permission = array_merge(array_filter(explode(',', json_decode($permission, true))), $user_permission);
                }
            }
        }
        return $user_permission;
    }

}
