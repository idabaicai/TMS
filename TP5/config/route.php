<?php
// use think\Route;
// Route::rule([
// 	'admin' 	=> 'admin/admin/login',
// 	'register'  => 'index/index/register'
// ]);

return [
	// 'register'	=>	'index/index/register',
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],

];