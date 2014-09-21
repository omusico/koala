<?php
//应用版本
define('APP_VERSION', '1');

define('CONTRLLER_PATH', APP_PATH . 'Application/Controller/');
define('MODEL_PATH', APP_PATH . 'Application/Model/');
define('VIEW_PATH', APP_PATH . 'Application/View/');

//projects
define('PROTECT_PATH_DEFAULT', ENTRANCE_PATH);
define('RELEASE_PATH_DEFAULT', PROTECT_PATH_DEFAULT . 'release');
/**
 * 应用的初始化过程
 */
\Core\Plugin\Manager::trigger('appInitialize', '', '', true);
\Core\Plugin\Manager::trigger('coreLazyInitialize', '', '', true);
\Core\Plugin\Manager::trigger('appLazyInitialize', '', '', true);
/**
 * 应用执行实现
 */
class Koala extends KoalaCore {}