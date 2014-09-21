<?php
//应用引导程序
//
defined('IN_KOALA') or define('IN_KOALA', true);
//默认调试级别设置
defined('DEBUGLEVEL') or define('DEBUGLEVEL', 1);
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
//
require_once (FRAME_PATH . 'Core/AE/' . env::$items['APP_ENGINE'] . '.php');
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
//加载应用核心
if (is_file(APP_PATH . 'Custom/Koala.php')) {require APP_PATH . 'Custom/Koala.php';
} else {//加载空核心
	require FRAME_PATH . 'Koala.php';
}
