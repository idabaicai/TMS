<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    // +----------------------------------------------------------------------
    // | 应用设置
    // +----------------------------------------------------------------------

    // 应用命名空间
    'app_namespace'          => 'app',
    // 应用调试模式
    'app_debug'              => true,
    // 应用Trace
    'app_trace'              => false,


    // 视图输出字符串内容替换
    'view_replace_str'       => [
        '__LAYUI__'     =>  '/static/index/lib/layui',
        '__SRC__'       =>  '/static/index',
        '__UPLOAD__'    =>  '/uploads'
    ],
    //分页配置
    'paginate'               => [
        'type'      => 'bootstrap',
        'var_page'  => 'page',
        'list_rows' => 15,
    ],
    //验证码参数
    'captcha' => [
            // 验证码字符集合
            'codeSet' => '2345678abcdefhijkmnpqrstuvwxyzABCDEFGHJKLMNPQRTUVWXY',
            // 验证码字体大小(px)
            'fontSize' => 25,
            // 是否画混淆曲线
            'useCurve' => true,
            // 验证码图片高度
            'imageH' => 50,
            // 验证码图片宽度
            'imageW' => 200,
            // 验证码位数
            'length' => 4,
            // 验证成功后是否重置
            'reset' => true
            ],
];
