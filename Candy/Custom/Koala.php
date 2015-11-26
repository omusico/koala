<?php
//应用版本
define('APP_VERSION', '1');

define('CONTRLLER_PATH', APP_PATH . 'Application/Controller/');
define('MODEL_PATH', APP_PATH . 'Application/Model/');
define('VIEW_PATH', APP_PATH . 'Application/View/');
/**
 * 应用的初始化过程
 */
hookTrigger('appInitialize', '', '', true);
hookTrigger('coreLazyInitialize', '', '', true);
hookTrigger('appLazyInitialize', '', '', true);
/**
 * 应用执行实现
 */
class Koala extends KoalaCore {}