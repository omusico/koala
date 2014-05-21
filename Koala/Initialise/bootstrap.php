<?php
//应用引导程序
define('IN_KOALA',true);

session_start();

//默认调试级别设置
defined('DEBUGLEVEL') or define('DEBUGLEVEL',0);

//是否运行于CLI模式
if(stripos(php_sapi_name(),'cli')!==false)define("RUNCLI",true);
else define("RUNCLI",false);

//加载框架CLI核心
if(RUNCLI)require FRAME_PATH.'Core/KoalaTask.php';
//加载框架WEB核心
else require FRAME_PATH.'Core/KoalaCore.php';

//加载应用核心
if(is_file(APP_PATH.'Custom/Koala.php'))require APP_PATH.'Custom/Koala.php';
//加载空核心
else require FRAME_PATH.'Koala.php';