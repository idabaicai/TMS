<?php
/**
 * Created by PhpStorm.
 * User: liuhui
 * Date: 2017/10/6
 * Time: 9:23
 */

namespace app\common;
use think\Controlleruse;
use think\Request;
use think\Db;

class Common extends Controller
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
    }

    /**
     * 返回Json数据
     * @param $status
     * @param $msg
     */
    public function returnJson($status,$msg)
    {
        $reArr=[
            'status'=>$status,
            'msg'   =>$msg
        ];
    }

    /**
     *根据每页显示的行数查询
     * @param $table    表名
     * @param $row      每页显示的行数
     * @return array|\think\db\Query|\think\Paginator
     */
    public function pageSelect($table,$row)
    {
        $num = Db::table($table)->select()->count();
        if($num>=$row){
            $list = Db::table($table)->paginate($row); //分页查询
            $page = $list->render();                //分页驱动
            return ['list'=>$list,'page'=>$page];
        }else{
            $list = Db::table($table);
            return $list;
        }
    }
}