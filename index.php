<?php
//调试
define('DEBUG',1);
//应用版本
define('APP_VERSION','1');
//入口绝对路径
define('ENTRANCE_PATH',dirname(__FILE__).DIRECTORY_SEPARATOR);
//应用绝对路径
define('APP_PATH',ENTRANCE_PATH.'App'.DIRECTORY_SEPARATOR);
//框架绝对路径
define('FRAME_PATH',ENTRANCE_PATH.'Koala'.DIRECTORY_SEPARATOR);
if (!defined('START_TIME')){
	define('START_TIME', $_SERVER['REQUEST_TIME_FLOAT']);
}
//引导应用程序
require FRAME_PATH.'Initialise/bootstrap.php';
//执行应用
Koala::execute();
?>