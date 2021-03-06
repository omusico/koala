<?php
/**
 * 请重命名 该文件为 index.php
 *
 * 然后增加一行代码
 *
 */
//调试级别
define('DEBUGLEVEL', 1);

//入口绝对路径
define('ENTRANCE_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);

//框架绝对路径
define('FRAME_PATH', ENTRANCE_PATH . 'Koala/');

/**
 * 应用绝对路径
 * 默认在 ENTRANCE_PATH.'MyApp/'处建立目录
 *
 * 请在此处增加一行代码用于定义应用目录路径
 * 可以取消下面语句的注释
 */
define('APP_PATH', ENTRANCE_PATH . 'Candy/');

//引导应用程序
require ENTRANCE_PATH . 'Initialise/Bootstrap.php';
//执行应用
Koala::execute();