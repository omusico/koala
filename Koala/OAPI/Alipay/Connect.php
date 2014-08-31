<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\OAPI\Alipay;
use Koala\OAPI\Base;
/**
 *  支付宝
 */

class Connect extends Base {
	/**
	 * 构造函数
	 */
	final public function __construct() {

		$this->cfg = include (__DIR__ . '/Api/alipay.auth.php');
	}
	/**
	 * 魔术方法
	 * @param  string $method 方法名
	 * @param  array $args   方法参数
	 * @return mixed         返回值
	 */
	public function __call($method, $args) {}
}