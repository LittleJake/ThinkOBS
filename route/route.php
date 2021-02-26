<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\facade\Route;

Route::get('/', 'index/OBS/bucket');
Route::get(':bucket/$', 'index/OBS/get');
Route::get(':bucket$', 'index/OBS/get');
Route::get('[:bucket]/:file$', 'index/OBS/get');
Route::put(':bucket$', 'index/OBS/put');
Route::put(':bucket/$', 'index/OBS/put');
Route::put('[:bucket]/:file$', 'index/OBS/put');
Route::delete(':bucket$', 'index/OBS/delete');
Route::delete(':bucket/$', 'index/OBS/delete');
Route::delete('[:bucket]/:file$', 'index/OBS/delete');
Route::miss('index/OBS/head','head');
Route::miss( 'index/OBS/miss');
return [

];
