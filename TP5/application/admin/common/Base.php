<?php
/**
 * Created by PhpStorm.
 * User: liuhui
 * Date: 2017/9/16
 * Time: 18:49
 */
namespace app\admin\common;
use think\Controller;
use think\Session;
use think\Request;
use think\Db;
use app\admin\model\User;
class Base extends Controller
{
    protected function _initialize()
    {
        parent::_initialize();      //继承父类中的初始化操作
        define('USER_ID',Session::get('user_id'));
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

    /**
     *获取$day天内用户
     * @param $day
     * @return array|false|\PDOStatement|string|\think\Model
     */
    public function getInfo($day)
    {
        $user = new User();
        $timestamp = $day*24*60*60;    //转换为时间戳
        $time = time()-$timestamp;      //当前时间减需要查询时间段的时间戳
        $result = $user->where('create_time','>',$time)->select();
        return $result;
    }

    /**
     * 删除$id的用户
     * @param $id   用户id
     * @return int
     */
    public function delUser($id)
    {
        $status = 0;
        $user = new User();
        $resule = $user->where('id',$id)->delete();
        if($resule){
            $status = 1;
        }
        return $status;
    }
    /**
     * 更改状态
     * @param Request $request
     */
//    public function setStatus(Request $request)
//    {
//        $id = $request->param('id');
//        $result = User::get($id);
//        //$result = Db::table($table)->where('id',$id)->select();
//        if($result->getData('status')==1){
//            User::update(['status'=>0],['id'=>$id]);
//        }else{
//            User::update(['status'=>1],['id'=>$id]);
//        }
//        $this->success('成功');
//    }
    public function setStatus(Request $request,$table)
    {
        $id = $request->param('id');
        $result = Db::table($table)->where('id',$id)->find();
        if ($result['status']==0){
            Db::table($table)->where('id',$id)->update(['status'=>1]);
        }else{
            Db::table($table)->where('id',$id)->update(['status'=>0]);
        }
         $this->success('成功！');
    }
    /**
     *根据每页显示的行数查询
     * @param $table    表名
     * @param $row      每页显示的行数
     * @return array|\think\db\Query|\think\Paginator
     */
    public function pageSelectList($table,$row)
    {
        $list = Db::table($table)->select();
        $num = count($list);
        if($num>=$row){
            $list = Db::table($table)->paginate($row); //分页查询
            $page = $list->render();                    //分页驱动
            $data['list'] = $list;
            $data['page'] = $page;
            return $data;
        }else{
            $list = Db::table($table)->select();
            return $list;
        }
    }
}