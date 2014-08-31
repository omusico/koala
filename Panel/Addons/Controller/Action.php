<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Addons\Controller;
use Plugin;
/**
 * Controller实现类
 */

class Action {
	/**
	 * 供插件管理器主动加载的入口
	 * @param string $plugin 插件管理器
	 */
	function __construct() {
		//你想自动挂接的钩子列表
		Plugin::only('registerController', array(&$this, 'register'));
	}
	/**
	 * 注册控制器加载方法并返回控制器类
	 * @param  array  $options [description]
	 * @return [type]          [description]
	 */
	public function register($options = array()) {
		if (C('MULTIPLE_GROUP')) {
			list($group, $module, $action) = $options['path'];
			!defined('GROUP_NAME') AND define('GROUP_NAME', $group);
			$class = $group . '\Controller\\' . $module;
		} else {
			list($module, $action) = $options['path'];
			$class                 = 'Controller\\' . $module;
		}
		!defined('MODULE_NAME') AND define('MODULE_NAME', ucwords($module));
		!defined('ACTION_NAME') AND define('ACTION_NAME', $action);
		return $class;
	}
}