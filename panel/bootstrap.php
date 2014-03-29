<?php
//应用引导程序
$cons_arr1 = get_defined_constants();
//加载框架核心
require FRAME_PATH.'Core/KoalaCore.php';
if(is_file(APP_PATH.'Custom/koala.php')){
	//加载应用核心
	require APP_PATH.'Custom/koala.php';
}else{
	//加载空核心
	require FRAME_PATH.'Koala.php';
}
$cons_arr2 = get_defined_constants();
$custom['const'] = array_diff($cons_arr2,$cons_arr1);

//设定时区
date_default_timezone_set(Config::getItem('time_zone'));

//设置本地化环境
setlocale(LC_ALL,"chs");

//不输出可替代字符
mb_substitute_character('none');

//定义页面输出字符串
define('CHARSET',Config::getItem('charset'));