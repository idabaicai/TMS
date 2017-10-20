<?php
/**
 * Created by PhpStorm.
 * User: liuhui
 * Date: 2017/9/17
 * Time: 11:26
 */

namespace app\admin\model;
use think\Model;
use think\Request;

class User extends Model
{
    //自动写入时间戳
    protected $autoWriteTimestamp = true;

    /**
     * 自动完成加密
     * @param $val
     * @return string
     */
    public function setPasswordAttr($val){
        return md5($val);
    }
    /**
     * 处理数据表中的角色信息并返回
     * @param $value
     * @return mixed
     */
    public function getRoleAttr($value)
    {
        $role = [
            0 => '管理员',
            1 => '超级管理员'
        ];
        return $role[$value];
    }
}