<?php
//不随配置变化的常量

defined('IN_Koala') or exit();

//控制器
define('CONTRLLER_PATH',ROOT_PATH.'App/Controller'.DS);
//模型目录
define('MODEL_PATH',ROOT_PATH.'App/Model'.DS);
//
define('LANG_PATH',ROOT_PATH.'App/Language'.DS);
//模板视图相关
define('VIEW_PATH',ROOT_PATH.'App/View'.DS);
//资源
define('SOURCE_URL', WEB_URL.'App/Source/');
//附加
define('ADDONS_PATH',FRAME_PATH.'Addons'.DS);
//插件库
define('PLUGIN_PATH',FRAME_PATH.'Addons/Plugin'.DS);
//读数据目录
define('DATA_PATH',FRAME_PATH.'Data'.DS);
//其他
define('WIDGET_PATH',FRAME_PATH.'Source/Widget/');
define('WIDGET_URL',WEB_URL.'Koala/Source/Widget/');


//存储目录
define('STOR_PATH',RUNTIME_PATH.'Storage'.DS);
define('STOR_URL','/'.ROOT_RELPATH.'Runtime/Storage/');

//编译目录
!defined('COMPILE_PATH')&&define('COMPILE_PATH',RUNTIME_PATH.'Compile'.DS);
//缓存目录
!defined('CACHE_PATH')&&define('CACHE_PATH',RUNTIME_PATH.'Cache'.DS);

//支持的URL模式
define('URL_COMMON',      1);   //普通模式
define('URL_PATHINFO',    2);   //PATHINFO模式
define('URL_COMPAT',      3);   // 兼容模式
define('URL_REWRITE',     4);   //REWRITE模式

//应用前缀
define('APR','C_');
?>