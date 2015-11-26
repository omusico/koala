<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Addons\Initialize;
/**
 * Initialize
 */
class Action extends \Koala\Addons\Initialize\Action {
	/**
	 * 供插件管理器主动加载的入口
	 * @param string $plugin 插件管理器
	 */
	function __construct() {
		\Core\Plugin\Manager::only('appInitialize', array(&$this, 'appInitialize'));
	}
	public function appInitialize($options = array()) {
		/**
		 * 应用类库加载方案
		 */
		\ClassLoader::initialize(function ($instance) {
			$instance->register();
			$instance->registerNamespaces(array(
				'Controller' => dirname(CONTRLLER_PATH),
				'Model' => dirname(MODEL_PATH),
				'Logic' => dirname(MODEL_PATH),
				'Library' => APP_PATH,
				'Custom' => APP_PATH,
				'Addons' => APP_PATH,
				'Tag' => FRAME_PATH . 'Extension',
			));
			$instance->registerDirs(array(
				APP_PATH . 'Custom',
			));
			$instance->loadFunc('Custom', 'Func');
		});
		/**
		 * 应用配置文件
		 */
		\Config::loadFile(APP_PATH.'/Config/LAEGlobal.user.php');
		is_file(APP_PATH . 'Vendor/autoload.php') AND require APP_PATH . 'Vendor/autoload.php';

		//
		\Request::parse();
	}
}