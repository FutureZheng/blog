<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Base\BaseAdminController;
use App\Repository\PermissionRepository;
use App\Repository\RoleAndPermissionRepository;
use App\Repository\RoleRepository as Role;
use Illuminate\Http\Request;

class RoleController extends BaseAdminController
{

    private $role = null;
    private $permission = null;
    private $role_and_permission = null;

    /**
     * 控制器实例化
     * RoleController constructor.
     * @param Role $role
     * @param RoleAndPermissionRepository $role_and_permission
     * @param PermissionRepository $permission
     */
    public function __construct(Role $role, RoleAndPermissionRepository $role_and_permission, PermissionRepository $permission){
        $this->role = $role;
        $this->role_and_permission = $role_and_permission;
        $this->permission = $permission;
    }

    /**
     * 获取角色列表数据
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        //获取角色列表
        $roles = $this->role->paginate();
        return view('admin.role.index', [
            'roles' => $roles
        ]);
    }

    /**
     * 创建角色
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add(){
        return view('admin.role.add');
    }

    /**
     * 更新角色
     * @param Request $request
     * @param integer $id   角色id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id){

        $this->validate($request, [
            'permissions' => 'bail|array'
        ], [
            'required' => ':attribute为必填项',
            'array' => ':attribute为数组'
        ], [
            'permissions' => '权限集合'
        ]);

        $permissions = $request->input('permissions', array());

        //判断数据是否存在
        if ( !$role = $this->role->find($id)){
            return back()->withInput($request->all())->with(['message' => '角色不存在']);
        }

        //查询用户，拥有的权限的集合
        $user_permissions = $this->role_and_permission->where('role_id', $role->id)->pluck('permission_id')->toArray();

        //查询出需要删除的角色
        $diff_delete_ids = array_diff($user_permissions, $permissions);

        if ( $diff_delete_ids ){
            //删除用户相关的角色
            $this->role_and_permission->delete($diff_delete_ids, 'permission_id');
        }

        //寻找需要添加了权限集合
        $diff_delete_ids = array_diff($permissions, $user_permissions);
        if ( $diff_delete_ids ){
            foreach ( $diff_delete_ids as $diff_delete_id){
                $this->role_and_permission->insert([
                    'role_id' => $role->id,
                    'permission_id' => $diff_delete_id,
                    'created_at' => get_time(),
                    'updated_at' => get_time()
                ]);
            }
        }

        return redirect('admin/role/index')->with(['message' => '权限设置成功']);
    }

    /**
     * 删除角色
     * @param integer $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id){

        if ( !$this->role->find($id) ){
            return redirect('admin/role/index')->with(['message' => '角色'. $id . '不存在']);
        }

        if ( !$this->role->delete($id) ){
            return redirect('admin/role/index')->with(['message' => '角色'.$id.'删除失败']);
        }

        return redirect('admin/role/index')->with(['message' => '角色删除成功']);

    }

    /**
     * 获取一条角色信息
     * @param integer $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit($id){
        $role = $this->role->find($id);
        if ( !$role ){
            return redirect('admin/role/index')->with(['message' => '角色不存在']);
        }

        //获取所有的权限
        $permissions = $this->permission->selectAll(['id', 'name', 'url']);

        //获取用户拥有的权限
        $role_and_permission = $this->role_and_permission->where('role_id', $role->id)->pluck('permission_id')->toArray();

        return view('admin.role.edit', [
            'role' => $role,
            'permissions' => $permissions,
            'role_and_permission' => $role_and_permission
        ]);
    }


    /**
     * 保存用户数据
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request){
        $this->validate($request, [
            'name' => 'bail|required|alpha_dash',
            'description' => 'bail|required'
        ], [
            'required' => ':attribute为必填项',
            'alpha_dash' => ':attribute仅包含字母、数字、破折号（ - ）以及下划线（ _ ）',
        ], [
            'name' => '角色名',
            'description' => '描述信息'
        ]);

        $data = $request->only('name', 'description');

        //判断数据是否存在
        if ( $this->role->findBy('name', $data['name'])){
            return back()->withInput($request->all())->with(['message' => '角色已经存在']);
        }

        //添加角色
        if ( !$this->role->insert([
            'name' => $data['name'],
            'description' => $data['description'],
            'created_at'  => get_time(),
            'updated_at'  => get_time()
        ])){
            return back()->withInput($request->all())->with(['message' => '角色创建失败']);
        }

        return redirect('admin/role/index')->with(['message' => '角色创建成功']);
    }
}
