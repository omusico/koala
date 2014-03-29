<?php
//应用引导程序
define('IN_Koala',true);
//加载框架核心
require FRAME_PATH.'Core/KoalaCore.php';
//应用路径
!defined('APP_PATH') AND define('APP_PATH',realpath(ROOT_PATH.'App').DIRECTORY_SEPARATOR);

defined("APP_ADDONS_PATH",APP_PATH.'Addons'.DS);
defined("APP_PLUGIN_PATH",APP_ADDONS_PATH.'Plugin'.DS);

if(is_file(APP_PATH.'Custom/Koala.php')){
	//加载应用核心
	require APP_PATH.'Custom/Koala.php';
}else{
	//加载空核心
	require FRAME_PATH.'Koala.php';
}
//设定时区
date_default_timezone_set(Config::getItem('time_zone'));

//设置本地化环境
setlocale(LC_ALL,"chs");

//不输出可替代字符
mb_substitute_character('none');

//定义页面输出字符串
define('CHARSET',Config::getItem('charset'));
//定义数据库配置
define('DB_TYPE',Config::getItem('DB_TYPE'));
define('DB_HOST_M',Config::getItem('DB_HOST_M'));
define('DB_PORT',Config::getItem('DB_PORT'));
define('DB_NAME',Config::getItem('DB_NAME'));
define('DB_USER',Config::getItem('DB_USER'));
define('DB_PASS',Config::getItem('DB_PASS'));
define('DB_PREFIX',Config::getItem('DB_PREFIX'));
define('DB_CHARSET',Config::getItem('DB_CHARSET'));