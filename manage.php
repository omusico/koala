<?php

//框架管理入口

//调试级别
define('DEBUGLEVEL',1);
//入口绝对路径
define('ENTRANCE_PATH',dirname(__FILE__).DIRECTORY_SEPARATOR);
//框架绝对路径
define('FRAME_PATH',ENTRANCE_PATH.'Koala'.DIRECTORY_SEPARATOR);
//Manage应用绝对路径
define('APP_PATH',ENTRANCE_PATH.'Manage'.DIRECTORY_SEPARATOR);
//引导应用程序
require FRAME_PATH.'Initialise/bootstrap.php';
//执行应用
Koala::execute();