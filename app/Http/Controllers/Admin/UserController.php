<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * 用户管理的相关模块
 * Date: 2017/8/11
 * Time: 13:04
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Base\BaseAdminController;
use App\Http\Requests\Admin\UserRequest;
use App\Repository\RoleRepository as Role;
use App\Repository\UserAndRoleRepository as UserAndRole;
use App\Repository\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends BaseAdminController{

    private $role = null;
    private $userRepository = null;
    private $user_and_role = null;

    /**
     * 注入user的契约
     * UserController constructor.
     * @param UserRepository $userRepository
     * @param UserAndRole $user_and_role
     * @param Role $role
     */
    public function __construct( UserRepository $userRepository, UserAndRole $user_and_role, Role $role){
        $this->userRepository = $userRepository;
        $this->user_and_role = $user_and_role;
        $this->role = $role;
    }

    /**
     * 用户列表的首页
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request){
        $data = $request->only('condition', 'keywords');        //获取用户的请求数组
        $users = $this->userRepository->getUserList($data);
        //获取用户的列表信息
        return view('admin.user.index', [
            'users' => $users,
            'condition' => $data['condition'],
            'keywords' => $data['keywords'],
            'userRepository' => $this->userRepository
        ]);
    }

    /**
     * 获取用户的数据
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit( $id){
        //获取用户的数据
        $user = $this->userRepository->find($id, ['id', 'username', 'email']);
        return view('admin/user/edit', [
            'user' => $user
        ]);
    }

    /**
     * 删除用户的数据
     * @param integer $id   用户id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete($id){
        $user = $this->userRepository->find($id);
        if ( !$user ){
            return back()->with('message', '用户不存在');
        }

        $data = $this->user_and_role->findIn($id);
        get_print($data);die;

        //删除用户的记录
        $this->userRepository->delete($id);

        //删除用户相关的关系表
        $this->user_and_role->delete();

        return redirect('admin/user/index')->with('message', '用户删除成功!!!');
    }

    /**
     * 添加用户页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add(){
        return view('admin.user.add');
    }

    /**
     * 添加用户数据
     * @param UserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request){

        $username = $request->input('username');
        $email = $request->input('email');
        $password = $request->input('password');        //获取用户输入的参数

        //查询用户数据
        $user = $this->userRepository->findBy('email', $email);
        if ( $user ){
            return back()->withInput($request->all())->with('message', '邮箱已经存在');
        }

        $data = array('username' => $username, 'email' => $email, 'password' => Hash::make($password), 'login_ip' => $request->getClientIp(), 'login_at' => get_time(), 'created_at' => get_time(), 'updated_at' => get_time());

        if ( !$this->userRepository->insert($data)){
            return redirect('admin/user/index')->with('message', '用户添加失败啦');
        }
        return redirect('admin/user/index')->with('message', '用户添加成功!!!');
    }

    /**
     * @param UserRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request, $id){

        $data = $request->only('username', 'email', 'old_password', 'password');        //获取客户端的数据

        //查询用户数据
        $user = $this->userRepository->find($id);
        if ( !$user ){
            return back()->withInput($request->all())->with('message', '用户不存在');
        }

        //如果原密码和新密码相同的时候，则提示错误信息
        if ( 0 === strcmp($data['old_password'], $data['password']) ){
            return back()->withInput($request->all())->with('message', '原密码不能和新密码相同');
        }

        //获取用户的密码信息
        if ( !Hash::check($data['old_password'], $user->password) ){
            return back()->withInput($request->all())->with('message', '用户名的原密码错误');
        }

        //重新加密用户数据，并且更新
        if ( !$this->userRepository->update(['password' => Hash::make($data['password']), 'updated_at' => get_time()], $user->id) ){
            return redirect('admin/user/index')->with('message', '密码更新失败');
        }
        return redirect('admin/user/index')->with('message', '用户添加成功!!!');
    }

    /**
     * 分配角色的页面
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function role($id){
        //获取用户的信息
        if ( !$user = $this->userRepository->find($id) ){
            return redirect('admin/user/index')->with(['message' => '用户'.$id .'不存在']);
        }
        //获取所有的角色
        $roles = $this->role->selectAll(['id', 'name']);

        //获取这个用户下面的橘色
        $user_and_role = $this->user_and_role->where('user_id', $id)->pluck('role_id')->toArray();

        return view('admin.user.role', [
            'user' => $user,
            'roles' => $roles,
            'user_and_role' => $user_and_role
        ]);
    }

    /**
     * 设置用户的角色
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function set(Request $request, $id){

        $this->validate($request, [
            'roles' => 'sometimes|array'
        ], [
            'required' => ':attribute为必填项',
            'array' => ':attribute为数组',
        ], [
            'roles' => '角色集合',
        ]);

        $roles = $request->input('roles', array());

        if ( !$user = $this->userRepository->find($id) ){
            return back()->withInput($request->all())->with(['message' => '用户'.$id .'不存在']);
        }

        //查询用户的角色集合
        $user_and_roles = $this->user_and_role->where('user_id', $id)->pluck('role_id')->toArray();

        //获取需要删除的角色
        $diff_user_roles = array_diff($user_and_roles, $roles);

        if ( $diff_user_roles ){
            $this->user_and_role->delete($diff_user_roles, 'role_id');
        }

        //判断需要添加的角色
        $diff_user_roles = array_diff($roles, $user_and_roles);
        if ( $diff_user_roles ){
            foreach ( $diff_user_roles as $diff_user_role){
                $this->user_and_role->insert([
                    'user_id' => $id,
                    'role_id' => $diff_user_role,
                    'created_at' => get_time(),
                    'updated_at' => get_time()
                ]);
            }
        }

        return redirect('admin/user/index')->with(['message' => '角色设置成功']);
    }

    /**
     * 用户修改密码页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function password(){
        return view('admin.user.password');
    }


    /**
     * 修改用户的密码
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function changePassword(Request $request){
        $this->validate($request, [
            'old_password' => 'bail|required',
            'new_password' => 'required|confirmed'
        ], [
            'required' => ':attribute为必填项',
            'confirmed' => '两次输入的密码不匹配'
        ], [
            'old_password' => '旧密码',
            'new_password' => '新密码'
        ]);

        $old_password = $request->input('old_password');
        $new_password = $request->input('new_password');

        //如果原密码和新密码相同的时候，则提示错误信息
        if ( 0 === strcmp($old_password, $new_password) ){
            return back()->withInput($request->all())->with('message', '原密码不能和新密码相同');
        }

        //判断当前用户是否存在
        $user = $this->userRepository->getUserInfoBuSession();
        if ( !$user ){
            //这边要做重定向，不能仅提醒
            return back()->withInput($request->all())->with('message', '登录用户信息不存在');
        }

        $user = $this->userRepository->find($user->id, ['id', 'password']);
        if ( !$user ){
            //这边仅提示用户信息不存在
            return back()->withInput($request->all())->with('message', '登录用户信息不存在');
        }

        //获取用户的密码信息
        if ( !Hash::check($old_password, $user->password) ){
            return back()->withInput($request->all())->with('message', '用户名的原密码错误');
        }

        //重新加密用户数据，并且更新
        if ( !$this->userRepository->update(['password' => Hash::make($new_password), 'updated_at' => get_time()], $user->id) ){
            return redirect('admin/index/info')->with('message', '密码更新失败');
        }
        return redirect('admin/index/info')->with('message', '密码更新成功');
    }
}