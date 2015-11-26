<?php
/**
 * 预定义某些常量
 */
//应用引导程序
//目录分隔符
defined('DS') or define('DS', DIRECTORY_SEPARATOR);
defined('IN_KOALA') or define('IN_KOALA', true);
//默认调试级QQ别设置
defined('DEBUGLEVEL') or define('DEBUGLEVEL', 1);

//环境完备性检测
require ENTRANCE_PATH . 'Initialise/integrity.php';
exit;
//是否存在目录
if(DEBUGLEVEL>0){
	if(!file_exists(FRAME_PATH)){
		exit('FRAME_PATH Not Exist');
	}
	if(!file_exists(APP_PATH)){
		exit('APP_PATH Not Exist');
	}
}
//检测
if (!is_file(APP_PATH . 'Custom/Koala.php')) {
	header('Location: ./manage.php?s=Start');
	exit;
} elseif (is_file(APP_PATH . 'Custom/Koala.php')
	 && !is_file(APP_PATH . 'Custom/install.lock')) {
	file_put_contents(APP_PATH . 'Custom/install.lock', 'start install');
	header('Location: ./index.php?s=install');
	exit;
}
//
require_once (FRAME_PATH . 'Core/CheckEnv.php');
//站点
define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST'] . env::$items['APP_RELATIVE_URL']);
define('SITE_RELATIVE_URL', env::$items['APP_RELATIVE_URL']);

//应用
define('APP_URL', SITE_URL);
define('APP_RELATIVE_URL', SITE_RELATIVE_URL);
define('SOURCE_RELATIVE_URL', env::$items['APP_RELATIVE_URL'] . 'Source/');

//加载框架CLI核心
if (env::$items['IS_CLI']) {require FRAME_PATH . 'Core/KoalaTask.php';
} else {//加载框架WEB核心
	require FRAME_PATH . 'Core/KoalaCore.php';
}
require_once (FRAME_PATH . 'Core/AE/' . env::$items['APP_ENGINE'] . '.php');
//加载应用核心
if (is_file(APP_PATH . 'Custom/Koala.php')) {require APP_PATH . 'Custom/Koala.php';
} else {//加载空核心
	require FRAME_PATH . 'Koala.php';
}