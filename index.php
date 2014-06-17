<?php

//框架测试 的 入口

//调试级别
define('DEBUGLEVEL',4);
//入口绝对路径
define('ENTRANCE_PATH',dirname(__FILE__).DIRECTORY_SEPARATOR);
//应用绝对路径
define('APP_PATH',ENTRANCE_PATH);
//框架绝对路径
define('FRAME_PATH',ENTRANCE_PATH.'Koala'.DIRECTORY_SEPARATOR);
//引导应用程序
require FRAME_PATH.'Initialise/bootstrap.php';

//coding-start
$img = Koala\Server\Image::factory('GDImage');
print_r($img);exit;