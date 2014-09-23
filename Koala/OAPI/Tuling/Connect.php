<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\OAPI\Tuling;
use Koala\OAPI\Base;

/**
 *图灵机器人
 *http://www.tuling123.com/
 * @abstract
 * @author    LunnLew <lunnlew@gmail.com>
 */
abstract class Connect extends Base {
	/**
	 * 构造函数
	 */
	final public function __construct() {
		$this->cfg = include (__DIR__ . '/Api/tuling.php');
	}
	/**
	 * 获取key
	 * @param  string $str [description]
	 * @return mixed
	 */
	abstract protected function _getAppKey($str = '');
}