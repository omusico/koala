<?php
define('IN_Koala', true);
define('DEBUG', 0);
//根路径
define('ROOT_PATH',realpath(dirname('../../')).DIRECTORY_SEPARATOR);
//应用路径
define('APP_PATH',realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR);
//框架路径
define('FRAME_PATH',realpath(ROOT_PATH.'Koala').DIRECTORY_SEPARATOR);
//引导应用程序
require APP_PATH.'bootstrap.php';
header("Content-type: text/html; charset=".CHARSET);

//执行应用
koala::execute();
?>