<?php
/**
 * LAE云引擎参数统一化
 * 
 */

//运行数据路径
defined('RUNTIME_PATH') or define('RUNTIME_PATH', APP_PATH . 'Runtime' . DS);
//--编译目录
defined('COMPILE_PATH') or define('COMPILE_PATH', RUNTIME_PATH . 'Compile' . DS);
//--缓存目录
defined('CACHE_PATH') or define('CACHE_PATH', RUNTIME_PATH . 'Cache' . DS);
//--日志路径
defined('LOG_PATH') or define('LOG_PATH', RUNTIME_PATH . 'Log' . DS);

//临时数据路径
if (env::$items['IS_WIN']) {
	//windows
	defined('TMP_PATH') or define('TMP_PATH', 'c:/temp/');
} else {
	//linux
	defined('TMP_PATH') or define('TMP_PATH', '/tmp/');
}

//存储数据路径
defined('STOR_PATH') or define('STOR_PATH', RUNTIME_PATH . 'Storage' . DS);


//框架类及云平台自有类统一化命名
if (C("enable_class_alias", false)) {
	class_alias('Koala\Server\Rank\Drive\\' . APP_ENGINE . 'Rank', 'Rank');
	class_alias('Koala\Server\KVDB\Drive\\' . APP_ENGINE . 'KVDB', 'KVDB');
	class_alias('Koala\Server\Counter\Drive\\' . APP_ENGINE . 'Counter', 'Counter');
	class_alias('Koala\Server\Storage\Drive\\' . APP_ENGINE . 'Storage', 'Storage');
}

//其他引用