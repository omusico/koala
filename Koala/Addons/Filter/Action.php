<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\Addons\Filter;
/**
 * Filter
 */

class Action extends \Core\Plugin\Base {
	/**
	 * 供插件管理器主动加载的入口
	 * @param string $plugin 插件管理器
	 */
	public function __construct() {
		parent::__construct(array());
		\Core\Plugin\Manager::only('inputFilter', array(&$this, 'inputFilter'), array('type' => 'all'));
	}
	/**
	 * [inputFilter description]
	 * see  http://www.w3school.com.cn/php/php_ref_filter.asp
	 * @param  string $type    [description]
	 * @param  [type] $filters [description]
	 * @return [type]          [description]
	 */
	public function inputFilter($type = 'all', $filters = FILTER_UNSAFE_RAW) {
		exit('TODO');
	}
}