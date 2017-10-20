<?php
/**
 * Created by PhpStorm.
 * User: liuhui
 * Date: 2017/9/21
 * Time: 16:22
 */

namespace app\admin\validate;
use think\Validate;

class User extends Validate
{
    protected $rule = [
        'username'  =>  'require',
        'password'=>'require',
        'verify|验证码'=>'require|captcha',
        'email'=>'email'
    ];
    protected $message = [
        'username.require'  =>  '姓名是必须的哦',
        'password.require'=>'密码是必须的哦'
    ];
    protected $scene = [
        'login' =>  'username,verify,password'
    ];
}