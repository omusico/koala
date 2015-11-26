<?php
/**
 * Koala - A PHP Framework For Web
 * 
 * 环境完备性检测
 * 
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
ini_set("display_errors", "On");

//必须支持的项目
//--目录是否准备完善
file_exists(FRAME_PATH) OR exit('目录['.FRAME_PATH.']不存在!');
file_exists(APP_PATH) OR exit('目录['.APP_PATH.']不存在!');

//--php版本最低需求
$min_version = "5.3";
(version_compare(PHP_VERSION,$min_version)===-1) AND exit('当前PHP运行版本[' . PHP_VERSION . "]低于[" . $min_version . "]!");



//建议支持的项目


//可选的项目


//可忽略项目


//运行模式
//--处于CGI模式
/*if((0 === strpos(PHP_SAPI, 'cgi') || false !== strpos(PHP_SAPI, 'fcgi')))*/

if(PHP_SAPI == 'cli')define('RUN_MODE','CLI');//--处于CLI模式
else define('RUN_MODE','WEB');//--处于WEB模式

if(strstr(PHP_OS, 'WIN'))define('SYS_MODE','WIN');//--处于WIN
else define('SYS_MODE','LINUX');//--处于linux

//--处于何种引擎
if (defined('SAE_ACCESSKEY')) define('RUN_ENGINE','SAE');
elseif (isset($_SERVER['HTTP_BAE_ENV_APPID'])) define('RUN_ENGINE','BAE');
else define('RUN_ENGINE','LAE');

//echo 'RUN_MODE:'.RUN_MODE.';	SYS_MODE:'.SYS_MODE.';	RUN_ENGINE:'.RUN_ENGINE;exit;