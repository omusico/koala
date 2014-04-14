<?php
define('IN_Koala', true);
define('DEBUG', 0);
//根路径
define('ENTRANCE_PATH',realpath(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR);
//框架路径
define('FRAME_PATH',realpath(ENTRANCE_PATH.'Koala').DIRECTORY_SEPARATOR);
//路径
define('APP_PATH',realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR);
//加载框架核心
require FRAME_PATH.'Core/KoalaCore.php';
if(is_file(APP_PATH.'Custom/KoalaTest.php')){
	//加载应用核心
	require APP_PATH.'Custom/KoalaTest.php';
}else{
	//加载空核心
	require FRAME_PATH.'Koala.php';
}
//执行应用
KoalaTest::execute();