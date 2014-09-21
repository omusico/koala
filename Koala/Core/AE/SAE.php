<?php
//----框架共有AE常量
//写数据路径
defined('RUNTIME_PATH') or define('RUNTIME_PATH', 'saemc://Runntime' . DS);
//日志路径
defined('LOG_PATH') or define('LOG_PATH', null);
//编译目录
defined('COMPILE_PATH') or define('COMPILE_PATH', 'saemc://Compile' . DS);
//缓存目录
defined('CACHE_PATH') or define('CACHE_PATH', 'saemc://Cache' . DS);

//----AE私有常量
define('DB_TYPE', 'mysql');
//MYSQL数据库常量
define('DB_HOST_M', SAE_MYSQL_HOST_M);//主库地址 'w.rdc.sae.sina.com.cn'
define('DB_HOST_S', SAE_MYSQL_HOST_S);//从库地址 'r.rdc.sae.sina.com.cn'
define('DB_PORT', SAE_MYSQL_PORT);//数据库端口 3307
define('DB_USER', SAE_MYSQL_USER);//数据库用户名 SAE_ACCESSKEY
define('DB_PASS', SAE_MYSQL_PASS);//数据库密码 SAE_SECRETKEY
define('DB_NAME', SAE_MYSQL_DB);//数据库名 'app_' . $_SERVER['HTTP_APPNAME']

C('DB_HOST_M', SAE_MYSQL_HOST_M, true);
C('DB_HOST_S', SAE_MYSQL_HOST_S, true);
C('DB_PORT', SAE_MYSQL_PORT, true);
C('DB_USER', SAE_MYSQL_USER, true);
C('DB_PASS', SAE_MYSQL_PASS, true);
C('DB_NAME', SAE_MYSQL_DB, true);