<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Base\BaseAdminController;
use App\Http\Requests\Admin\PermissionRequest;
use App\Repository\PermissionRepository as Permission;

class PermissionController extends BaseAdminController
{
    private $permission = null;

    public function __construct(Permission $permission){
        $this->permission = $permission;
    }

    public function index(){
        //获取权限列表
        $permissions = $this->permission->selectAll(['id', 'name', 'description', 'url', 'created_at', 'updated_at']);

        return view('admin.permission.index', [
            'permissions' => $permissions
        ]);
    }

    /**
     * 创建权限
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add(){
        return view('admin.permission.add');
    }

    /**
     * 保存权限信息
     * @param PermissionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PermissionRequest $request){

        $data = $request->only('name', 'description', 'url');

        //判断数据是否存在
        if ( $this->permission->findBy('name', $data['name'])){
            return back()->withInput($request->all())->with(['message' => '权限经存在']);
        }

        //添加角色
        if ( !$this->permission->insert([
            'name' => $data['name'],
            'description' => $data['description'],
            'url' => json_encode(array_map(function ($value){return trim($value);}, explode(',', $data['url']))),
            'created_at'  => get_time(),
            'updated_at'  => get_time()
        ])){
            return back()->withInput($request->all())->with(['message' => '权限创建失败']);
        }

        return redirect('admin/permission/index')->with(['message' => '权限创建成功']);
    }

    /**
     * 编辑权限
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit($id){
        $permission = $this->permission->find($id);
        if ( !$permission ){
            return back()->with(['message' => '权限'.$id.'不存在']);
        }
        return view('admin.permission.edit', [
            'permission' => $permission
        ]);
    }

    /**
     * 根据id删除指定的权限
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id){
        if ( !$this->permission->find($id) ){
            return back()->with(['message' => '权限'.$id.'不存在']);
        }
        if ( !$this->permission->delete($id) ){
            return back()->with(['message' => '权限'.$id.'删除失败']);
        }

        return back()->with(['message' => '权限删除成功']);
    }

    /**
     * 更新权限
     * @param PermissionRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PermissionRequest $request, $id){

        $data = $request->only('name', 'description', 'url');

        $data['url'] = array_map(function ($value){return trim($value);},explode(',', $data['url']));

        //判断数据是否存在
        if ( !$this->permission->find($id)){
            return back()->withInput($request->all())->with(['message' => '权限不存在']);
        }

        //添加角色
        if ( !$this->permission->update([
            'name' => $data['name'],
            'description' => $data['description'],
            'url' => json_encode($data['url']), //这边需要删除每一个字符串后面的空行
            'updated_at'  => get_time()
        ], $id)){
            return back()->withInput($request->all())->with(['message' => '权限更新失败']);
        }

        return redirect('admin/permission/index')->with(['message' => '权限更新成功']);
    }
}
