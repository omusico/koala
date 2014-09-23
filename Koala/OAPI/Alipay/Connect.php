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
 * @abstract
 * @author    LunnLew <lunnlew@gmail.com>
 */
abstract class Connect extends Base {
	/**
	 * 构造函数
	 */
	final public function __construct() {
		$this->cfg = include (__DIR__ . '/Api/alipay.auth.php');
	}
}