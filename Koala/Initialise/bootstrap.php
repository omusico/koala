<?php
//应用引导程序

$cons_arr1 = get_defined_constants();

//加载框架核心
require FRAME_PATH.'Core/KoalaCore.php';

if(Config::getItem('site_disable')){
	die('网站维护中...');
}
if(is_file(APP_PATH.'Custom/Koala.php')){
	//加载应用核心
	require APP_PATH.'Custom/Koala.php';
}else{
	//加载空核心
	require FRAME_PATH.'Koala.php';
}
$cons_arr2 = get_defined_constants();
$custom['const'] = array_diff($cons_arr2,$cons_arr1);

View::assign('Koala',$custom);

//设定时区
date_default_timezone_set(Config::getItem('time_zone'));

//设置本地化环境
setlocale(LC_ALL,"chs");

//不输出可替代字符
mb_substitute_character('none');

//定义页面输出字符串
define('CHARSET',Config::getItem('charset'));
//是否是ajax请求
define("IS_AJAX",is_ajax());
//定义数据库配置
!defined('DB_TYPE')&&define('DB_TYPE',Config::getItem('DB_TYPE'));
!defined('DB_HOST_M')&&define('DB_HOST_M',Config::getItem('DB_HOST_M'));
!defined('DB_PORT')&&define('DB_PORT',Config::getItem('DB_PORT'));
!defined('DB_NAME')&&define('DB_NAME',Config::getItem('DB_NAME'));
!defined('DB_USER')&&define('DB_USER',Config::getItem('DB_USER'));
!defined('DB_PASS')&&define('DB_PASS',Config::getItem('DB_PASS'));
!defined('DB_PREFIX')&&define('DB_PREFIX',Config::getItem('DB_PREFIX'));
!defined('DB_CHARSET')&&define('DB_CHARSET',Config::getItem('DB_CHARSET'));

//设定Session_Memcache
//new SessionToMMC(Factory_Cache::getInstance('Memcache','Session'));

//数据库帐户是你独有时,下面的代码可以用来解决共享主机的session数据暴露问题
//new SessionToDB(Factory_Db::getInstance('LAEPDO'));

//注册缓存句柄