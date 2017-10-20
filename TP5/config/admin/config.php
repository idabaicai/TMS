<?php
/**
 * Created by PhpStorm.
 * User: liuhui
 * Date: 2017/10/6
 * Time: 9:54
 */
return [
    //分页配置
    'paginate'               => [
        'type'      => 'bootstrap',
        'var_page'  => 'page',
        'list_rows' => 10
    ],
    // 视图输出字符串内容替换
    'view_replace_str'       => [
        '__BS__'	=> '/static/admin/lib/bootstrap',
        '__SRC__'       =>  '/static/index',
        '__LAYUI__'     =>  '/static/index/lib/layui',
        '__UPLOAD__'    =>  '/uploads'
    ],
];