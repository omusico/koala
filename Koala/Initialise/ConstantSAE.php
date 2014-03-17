<?php
defined('IN_Koala') or exit();
//-------------以下是目录常量-------------------//
//编译目录
define('COMPILE_PATH','saemc://Compile'.DS);
//缓存目录
define('CACHE_PATH','saemc://Cache'.DS);
define( 'DB_TYPE','mysql');
//MYSQL数据库常量
define( 'DB_HOST_M', SAE_MYSQL_HOST_M);//主库地址 'w.rdc.sae.sina.com.cn'
define( 'DB_HOST_S', SAE_MYSQL_HOST_S);//从库地址 'r.rdc.sae.sina.com.cn'
define( 'DB_PORT', SAE_MYSQL_PORT);//数据库端口 3307
define( 'DB_USER', SAE_MYSQL_USER);//数据库用户名 SAE_ACCESSKEY
define( 'DB_PASS', SAE_MYSQL_PASS);//数据库密码 SAE_SECRETKEY
define( 'DB_NAME', SAE_MYSQL_DB);//数据库名 'app_' . $_SERVER['HTTP_APPNAME']
?>