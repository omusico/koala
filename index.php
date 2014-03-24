<?php
define('IN_Koala',true);
//调试
define('DEBUG',1);
//应用版本
define('APP_VERSION','1');
//根路径
define('ROOT_PATH',realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR);
//应用路径
define('APP_PATH',realpath(ROOT_PATH.'App').DIRECTORY_SEPARATOR);
//框架路径
define('FRAME_PATH',realpath(ROOT_PATH.'Koala').DIRECTORY_SEPARATOR);

if (!defined('START_TIME')){
	define('START_TIME', $_SERVER['REQUEST_TIME_FLOAT']);
}
//引导应用程序
require FRAME_PATH.'Initialise/bootstrap.php';
//执行应用
Koala::execute();
?>