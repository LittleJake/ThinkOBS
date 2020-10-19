<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

function rand_num($num = 10){
    $s = '0123456789';
    $str = '';
    while(($num--) > 0)
        $str.=substr($s,intval(rand(0,strlen($s)-1)),1);

    return $str;
}

function rand_str($num = 10){
    $s = 'abcdefghijklnmopqrstuvwxyz0123456789';
    $str = '';
    while(($num--) > 0)
        $str.=substr($s,intval(rand(0,strlen($s)-1)),1);

    return $str;
}

function rand_hex($num = 10){
    $s = 'abcdef0123456789';
    $str = '';
    while(($num--) > 0)
        $str.=substr($s,intval(rand(0,strlen($s)-1)),1);

    return $str;
}