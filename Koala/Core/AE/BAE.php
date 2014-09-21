<?php
//----框架共有AE常量
//写数据路径
defined('RUNTIME_PATH') or define('RUNTIME_PATH', sys_get_temp_dir() . DS);
//日志路径
defined('LOG_PATH') or define('LOG_PATH', RUNTIME_PATH . 'Storage' . DS);
//编译目录
defined('COMPILE_PATH') or define('COMPILE_PATH', RUNTIME_PATH . 'Compile' . DS);
//缓存目录
defined('CACHE_PATH') or define('CACHE_PATH', RUNTIME_PATH . 'Cache' . DS);

//----AE私有常量
//AK 公钥
define('BCS_AK', '');
//SK 私钥
define('BCS_SK', '');
//superfile 每个object分片后缀
define('BCS_SUPERFILE_POSTFIX', '_bcs_superfile_');
//sdk superfile分片大小 ，单位 B（字节）
define('BCS_SUPERFILE_SLICE_SIZE', 1024 * 1024);

//----AE类库
require_once ("BaeRank.class.php");
require_once ("BaeRankManager.class.php");
require_once ("BaeCounter.class.php");
