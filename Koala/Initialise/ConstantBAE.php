<?php
//编译目录
define('COMPILE_PATH',sys_get_temp_dir().'/Compile'.DS);
//缓存目录
define('CACHE_PATH',sys_get_temp_dir().'/Cache'.DS);
//AK 公钥
define ( 'BCS_AK', '' );
//SK 私钥
define ( 'BCS_SK', '' );
//superfile 每个object分片后缀
define ( 'BCS_SUPERFILE_POSTFIX', '_bcs_superfile_' );
//sdk superfile分片大小 ，单位 B（字节）
define ( 'BCS_SUPERFILE_SLICE_SIZE', 1024 * 1024 );