<?php
//控制器
define('CONTRLLER_PATH',APP_PATH.'Controller'.DS);
//模型目录
define('MODEL_PATH',APP_PATH.'Model'.DS);
//
define('LANG_PATH',APP_PATH.'Language'.DS);
//模板视图相关
define('VIEW_PATH',APP_PATH.'View'.DS);
//资源
define('SOURCE_URL', APP_URL.'Source'.DS);
//读数据目录
define('DATA_PATH',FRAME_PATH.'Data'.DS);
//存储目录
define('STOR_PATH',RUNTIME_PATH.'Storage'.DS);
define('STOR_URL','/'.APP_RELATIVE_URL.'Runtime/Storage'.DS);
//编译目录
define('COMPILE_PATH',RUNTIME_PATH.'Compile'.DS);
//缓存目录
define('CACHE_PATH',RUNTIME_PATH.'Cache'.DS);
//内置资源库
define('THIRD_PATH',FRAME_PATH.'Source');
define('THIRD_URL',SITE_URL.'Koala/Source');

define('WIDGET_PATH',FRAME_PATH.'Source/Widget/');
define('WIDGET_URL',SITE_URL.'Koala/Source/Widget/');
?>