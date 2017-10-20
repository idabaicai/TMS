<?php
/**
 * Created by PhpStorm.
 * User: liuhui
 * Date: 2017/10/4
 * Time: 18:54
 */

namespace app\index\validate;
use think\Validate;

class UserInfo extends Validate
{
    protected $rule = [
        'name'  =>  'require',
        'password|密码'=>'require|min:3',
        'verify|验证码'=>'require|captcha',
        'email|邮箱'=>'email'
    ];
    protected $message = [
        'name.require'  =>  '姓名是必须的哦',
        'password.require'=>'密码是必须的哦'
    ];
    protected $scene = [
        'login' =>  'name,password,verify',
        'register' => 'name,password,email'
    ];
}