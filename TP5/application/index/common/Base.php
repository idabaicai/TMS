<?php
/**
 * Created by PhpStorm.
 * User: liuhui
 * Date: 2017/10/4
 * Time: 18:43
 */

namespace app\index\common;
use think\Controller;
use think\Session;
use think\Request;
use app\index\model\Userinfo;

class Base extends Controller
{
    public function _initialize()
    {
        parent::_initialize(); // 初始化
        define('USER_ID',Session::set('user_sid'));  //定义常量
    }
    /**
     *判断用户是否登录 放在后台的admin/index
     */
    protected function islogin()
    {
        if(empty(USER_ID)) {
            $this->error('请登录', url('admin/login'));
        }
    }

    /**
     * 防止重复登录
     */
    protected function alreadyLogin()
    {
        if(!empty(USER_ID)){
            $this->error('无需重复登录',url('index/index'));
        }
    }

    /**
     * 检查用户名是否可用
     * @param Request $request
     * @return array
     */
    public function checkUserName(Request $request)
    {
        //默认用户名可用
        $status = 1;
        $message = '用户名可用';
        $name = trim($request->param('name'));
        if(User::get(['name'=>$name])){
            $status = 0;
            $message = '用户名不可用，请重新输入';
        }
        return ['status'=>$status,'message'=>$message];
    }
}