<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Base\BaseAdminController;
use App\Http\Requests\Admin\LoginRequest;
use App\Repository\UserRepository;
use Illuminate\Support\Facades\Hash;

class LoginController extends BaseAdminController
{
    private $userRepository = null;

    public function __construct(UserRepository $userRepository){
        $this->userRepository = $userRepository;
    }

    /**
     * 后台的首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        if ( $this->userRepository->getUserInfoBySession() ){    //如果用户登录，则跳转到登录的页面
            return redirect('admin/index/index');
        }
        return view('admin.login.index');
    }

    /**
     * 用户登录
     * @param LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function login(LoginRequest $request){

        $email = $request->input('email');
        $password = $request->input('password');

        $user = $this->userRepository->findBy('email', $email);
        if ( !$user ){
            return back()->withInput($request->all())->with('message', '用户不存在');
        }

        //验证用户的密码信息
        if ( !Hash::check($password, $user->password) ){
            return back()->withInput($request->all())->with('message', '输入的密码错误');
        }

        //记录用户的登录信息
        $this->remember($user, $request->getClientIp());

        return redirect('admin/index/index');
    }

    /**
     * 记录用户的登录信息
     * @param object $user  用户的信息
     * @param string $ip   用户登录的ip
     */
    private function remember($user, $ip){
        unset($user->password);

        session(['user'=> $user]);

        //保存用户的最后登录时间和登录的ip
        $this->userRepository->update(['login_ip' => $ip, 'login_at' => get_time(), 'updated_at' => get_time()], $user->id);
    }

    /**
     * 用户退出登录
     */
    public function logout(){
        $this->userRepository->setUserInfoToSession(null);      //清除登录用户的session
        return redirect('admin/login/index');
    }

}
