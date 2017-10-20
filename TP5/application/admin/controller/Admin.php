<?php
/**
 * Created by PhpStorm.
 * User: liuhui
 * Date: 2017/9/16
 * Time: 20:52
 */

namespace app\admin\controller;
use app\admin\common\Base;
use app\common\Common;
use think\Db;
use think\Request;
use think\Loader;
use think\Session;
use app\admin\model\User;

class Admin extends Base
{
    protected $table = 'user';
    /**管理员登录
     * @return view
     */
    public function login()
    {
        $this->alreadyLogin();   //判断是否重复登录
        return $this->fetch();
    }

    /**管理员登录验证
     * @param Request $request
     * @return array
     */
    public function dologin(Request $request)
    {
        //
        //初始化返回参数
        $status = 1;
        $message = "登录成功！";
        $data = $request->param();  //前端提交的数据;
        $name = $request->param('username');
        $validate =Loader::validate('User');    //加载验证器
        $result = $validate->scene('login')->check($data);
        if(!$result){               //如果验证不通过
            $status = 0;
            $message = $validate->getError();
        }else{
            //查询条件
            $map = [
                'name'      =>$data['username'],
                'password'  => md5($data['password'])
            ];
            //进行数据库查询
            $user = User::get($map);
            if(!$user){
                $status = 0;
                $message = "姓名或密码错误，请重新输入";
            }else{
                $status = 1;
                $message = "登录成功！";
                //更新登录时间个次数
                $login_count = $user->getData('login_count');
                $login_count++;          //登录次数加1
                $login_time =time();
                //更新为当前时间
                //更新
                User::update(['login_time'=>$login_time,'login_count'=>$login_count],['name'=>$data['username']]);
                //设置管理员session
                Session::set('user_id',$user->id);
                Session::set('user_info',$user->getData());
            }
        }
        return [
            'status'   =>$status,
            'message'  =>$message
        ];
    }
    /**
     * 退出登录
     */
    public function logout()
    {
        //注销Session
        Session::delete('user_id');
        Session::delete('user_info');
        $this->success('注销成功','admin/login');
    }

    /**
     * 从数据库取出管理员
     * @return mixed
     */
    public function adminList()
    {
        $row = 3;
        $this->isLogin();       //是否登录
        $name = Session::get('user_info.name');
        //只有admin才能查看所有管理员
        if ($name==='admin'){
              $data = $this->pageSelectList('user',$row);
              if(isset($data['page'])){
                  $list = $data['list'];
                  $page = $data['page'];
              }else{
                  $list = $data;
              }
              $num = count($data);
        }else{
            $list = User::all(['name'=>$name]);
            $num = count($list);
        }
        if(isset($page)){
            $this->assign('page',$page);
        }
        $this->assign(['list'=>$list,'num'=>$num]);
        return $this->fetch('admin-list');
    }

    /**
     * 用户角色管理
     * @return mixed
     */
    public function adminRole(){
        $this->isLogin();       //是否登录
        $name = Session::get('user_info.name');
        //只有admin才能管理角色
        if ($name==='admin'){
            $list = User::all();
        }else{
            $list = User::all(['name'=>$name]);
        }
        $num = count($list);
        $this->assign(['list'=>$list,'num'=>$num]);
        return $this->fetch('admin-role');
    }

    /**
     * 管理员角色编辑
     * @return mixed
     */
    public function roleEdit(){
        return $this->fetch('role-edit');
    }
    /**
     * 根据id渲染编辑编辑模板
     * @param Request $request
     * @return mixed
     */
    public function adminEdit(Request $request)
    {
        $user_id = $request->param('id');
        $result = User::get($user_id);
        $this->assign('user_info',$result->getData());
        return $this->fetch('admin-edit');
    }

    /**
     * 渲染添加用户的模板
     * @return mixed
     */
    public function add(){
        return $this->fetch('admin-add');
    }
    /**添加管理员
     * @param Request $request
     * @return array
     */
    public function addUser(Request $request)
    {
        $status = 1;
        $message = "新增成功！";
        $data = $request->param();
        $user = User::create($data,true);
        if($user==null){
            $status = 0;
            $message = "新增失败";
        }
        if ($status==0){
            $this->error($message,'admin/adminList');
        }else{
            $this->success($message,'admin/adminList');
        }
    }

    /**
     * 更改用户状态
     * @param Request $request
     */
    public function changeStatus(Request $request)
    {
        $table = $this->table;
        $this->setStatus($request,$table);
    }

    public function editUser(Request $quest)
    {
        $param = $quest->param();
        $name = $quest->param('name');
        foreach ($param as $key=>$value){           //如果字段为空就不处理
            if(!empty($value)){
                $data[$key] = trim($value);          //将非空并去掉空格的数据和键名保存在新数组中
            }
        }
        $user = User::where('name',$name)->update($data);
        if($user){
            $this->success('success');
        }
    }
    public function test()
    {
        dump(config());
    }
}