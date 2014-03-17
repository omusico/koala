<?php
define('IN_Koala',true);
//调试
define('DEBUG',0);
//主版本
define('APP_VERSION','1');
//根路径
define('ROOT_PATH',realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR);
//框架路径
define('FRAME_PATH',realpath(ROOT_PATH.'Koala').DIRECTORY_SEPARATOR);

if (!defined('START_TIME')){
	define('START_TIME', microtime(TRUE));
}
//引导应用程序
require FRAME_PATH.'Initialise/bootstrap.php';
//引导结束时间
$init_end_time = microtime(true);

env::$items['INIT_TIME'] = (($init_end_time-START_TIME)*1000).'ms';
//echo env::$items['INIT_TIME'];exit;
//执行应用
Koala::execute();
?>