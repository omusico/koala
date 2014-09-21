<?php
//----框架共有AE常量
//写数据路径
defined('RUNTIME_PATH') or define('RUNTIME_PATH', APP_PATH . 'Runtime' . DS);
//日志路径
defined('LOG_PATH') or define('LOG_PATH', RUNTIME_PATH . 'Storage' . DS);
//编译目录
defined('COMPILE_PATH') or define('COMPILE_PATH', RUNTIME_PATH . 'Compile' . DS);
//缓存目录
defined('CACHE_PATH') or define('CACHE_PATH', RUNTIME_PATH . 'Cache' . DS);