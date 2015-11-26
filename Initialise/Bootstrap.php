<?php
/**
 * Koala - A PHP Framework For Web
 * 
 * 应用引导程序
 * 
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */

//目录分隔符
defined('DS') or define('DS', DIRECTORY_SEPARATOR);
defined('IN_KOALA') or define('IN_KOALA', true);
//默认调试级别设置
defined('DEBUGLEVEL') or define('DEBUGLEVEL', 1);

//环境完备性检测
require ENTRANCE_PATH . 'Initialise/Integrity.php';
//框架基本参数设置
require ENTRANCE_PATH . 'Initialise/FrameParams.php';

//加载框架核心
if(RUN_MODE==='WEB') require FRAME_PATH . 'Core/KoalaCore.php';//WEB核心
else require FRAME_PATH . 'Core/KoalaTask.php';//CLI核心

//加载引擎资源
require_once (FRAME_PATH . 'Core/AE/' . RUN_ENGINE . '.php');

//加载应用核心
if (file_exists(APP_PATH . 'Custom/Koala.php')) require APP_PATH . 'Custom/Koala.php';
else require FRAME_PATH . 'Koala.php';//加载空核心