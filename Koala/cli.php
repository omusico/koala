<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
//调试级别
define('DEBUGLEVEL',0);
//入口绝对路径
define('ENTRANCE_PATH',dirname(__FILE__).DIRECTORY_SEPARATOR);
//应用绝对路径
define('APP_PATH',ENTRANCE_PATH);
//写数据路径
define('RUNTIME_PATH',ENTRANCE_PATH.'Runtime/');
//日志路径
define('LOG_PATH',RUNTIME_PATH.'Storage/');

//框架绝对路径
define('FRAME_PATH',ENTRANCE_PATH);
if (!defined('START_TIME')&&isset($_SERVER['REQUEST_TIME_FLOAT'])){
	define('START_TIME', $_SERVER['REQUEST_TIME_FLOAT']);
}
//引导应用程序
require ENTRANCE_PATH.'Initialise/bootstrap.php';
//执行应用
KoalaCore::execute();