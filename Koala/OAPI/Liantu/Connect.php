<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\OAPI\Liantu;
use Koala\OAPI\Base;
/**
 * 联图网 二维码 api
 *
 * http://www.liantu.com/pingtai/
 */

class Connect extends Base {
	/**
	 * 构造函数
	 */
	final public function __construct() {

		$this->cfg = include (__DIR__ . '/Api/liantu.php');
	}
	/**
	 * 魔术方法
	 * @param  string $method 方法名
	 * @param  array $args   方法参数
	 * @return mixed         返回值
	 */
	public function __call($method, $args) {}
}