<?php
/**
 * @package  Library
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Library\OAPI\Tuling;
/**
 *图灵机器人
 *http://www.tuling123.com/
 */
class Connect extends \Koala\OAPI\Tuling\Connect {
	/**
	 * 获取key
	 * @param  string $str [description]
	 * @return mixed
	 */
	protected function _getAppKey($str = '') {
		exit('_getAppKey');
	}
}