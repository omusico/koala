<?php
//应用引导程序
define('IN_Koala',true);

//运行模式
$is_cli = false;
if(stripos(php_sapi_name(),'cli')!==false){$is_cli = true;}
//cli模式下,$_SERVER['OS']有效
if($is_cli&&stripos($_SERVER['OS'],'Win')!==false){
	define('CONSOLE_CHARSET','GBK');
}else{
	define('CONSOLE_CHARSET','UTF-8');
}
define("RUNCLI",$is_cli);

//加载框架核心
require FRAME_PATH.'Core/KoalaCore.php';
//应用路径
!defined('APP_PATH') AND define('APP_PATH',ENTRANCE_PATH.'App'.DIRECTORY_SEPARATOR);
!defined("APP_ADDONS_PATH") and define("APP_ADDONS_PATH",APP_PATH.'Addons'.DS);
!defined("APP_PLUGIN_PATH") and define("APP_PLUGIN_PATH",APP_ADDONS_PATH.'Plugin'.DS);

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