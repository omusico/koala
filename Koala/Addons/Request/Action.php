<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\Addons\Request;
/**
 * Request实现类
 */
class Action {
	/**
	 * 供插件管理器主动加载的入口
	 * @param string $plugin 插件管理器
	 */
	function __construct() {
		//你想自动挂接的钩子列表
		\Core\Plugin\Manager::only('registerRequest', array(&$this, 'register'));
	}
	/**
	 * 注册
	 * @param  array  $options [description]
	 * @return [type]          [description]
	 */
	public function register($options = array()) {
		$u        = \Core\AOP\AOP::getInstance('URL');
		$test_url = rtrim(APP_RELATIVE_URL, '/');
		if (!empty($test_url)) {
			$url = str_replace(APP_RELATIVE_URL, '', $_SERVER['REQUEST_URI']);
		} else {

			$url = $_SERVER['REQUEST_URI'];
		}
		//请求选项
		return $u->requestOption($url, 1);
	}
}