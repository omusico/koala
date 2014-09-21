<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\Addons\Front;
class Action {
	/**
	 * 供插件管理器主动加载的入口
	 * @param string $plugin 插件管理器
	 */
	function __construct() {
		//你想自动挂接的钩子列表
		\Core\Plugin\Manager::only('setRequestType', array(&$this, 'setRequestType'));
	}
	function setRequestType() {
		switch (false) {
			case is_ajax():
				$GLOBALS['request_type'] = 'ajax';
				break;
			default:
				$GLOBALS['request_type'] = 'common';
				break;
		}
	}
	function output() {
		echo \FrontData::toJson();
		exit;
	}
}