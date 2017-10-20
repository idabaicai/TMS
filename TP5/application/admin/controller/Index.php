<?php
/**
 * Created by PhpStorm.
 * User: liuhui
 * Date: 2017/9/16
 * Time: 18:45
 */

namespace app\admin\controller;
use app\admin\common\Base;
use app\admin\model\User;
use think\Session;

class Index extends Base
{
    public  function index()
    {
        $this->isLogin();       //判断是否登录
        return $this->view->fetch();
    }

    /**
     * 欢迎页面
     * @return mixed
     */
    public function welcome()
    {
        $this->isLogin();       //判断是否登录
        $username = Session::get('user_info.name'); //从Session中获取当前登录用户的姓名
        $data = User::get(['name'=>$username]);              //从数据库中获取信息
        $count = User::count();                               //获取管理员总数
        $todaynum = count($this->getInfo(1));                  //今日增加的用户
        $weeknum = count($this->getInfo(7));                   //本周新增用户
        $mouthnum = count($this->getInfo(30));                 //本月新增用户
        $this->assign(['data'=>$data,'count'=>$count,'todaynum'=>$todaynum,'weeknum'=>$weeknum,'mouthnum'=>$mouthnum]);
        return $this->fetch();
    }
    public function memberList()
    {
        $this->isLogin();       //判断是否登录
        return $this->fetch('index/member-list');
    }
    public function memberDel()
    {
        $this->isLogin();       //判断是否登录
        return $this->fetch('index/member-del');
    }
    public function orderList()
    {
        $this->isLogin();       //判断是否登录
        return $this->fetch('index/order-list');
    }
}