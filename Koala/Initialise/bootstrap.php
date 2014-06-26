<?php
//应用引导程序
define('IN_KOALA',true);

//默认调试级别设置
defined('DEBUGLEVEL') or define('DEBUGLEVEL',0);

//是否运行于CLI模式
if(stripos(php_sapi_name(),'cli')!==false)define("RUNCLI",true);
else define("RUNCLI",false);

//检测
if(!is_file(APP_PATH . 'Custom/Koala.php')){
	header('Location: ./panel.php?s=Start');
	exit;
}elseif(is_file(APP_PATH . 'Custom/Koala.php')
	&&!is_file(APP_PATH . 'Custom/installing.lock')
	&&!is_file(APP_PATH . 'Custom/install.lock')){
	file_put_contents(APP_PATH . 'Custom/installing.lock', 'start install');
	header('Location: ./index.php?s=install');
	exit;
}

//加载框架CLI核心
if(RUNCLI)require FRAME_PATH.'Core/KoalaTask.php';
//加载框架WEB核心
else require FRAME_PATH.'Core/KoalaCore.php';

//加载应用核心
if(is_file(APP_PATH.'Custom/Koala.php'))require APP_PATH.'Custom/Koala.php';
//加载空核心
else require FRAME_PATH.'Koala.php';