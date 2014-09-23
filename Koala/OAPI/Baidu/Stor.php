<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\OAPI\Baidu;
use Koala\OAPI\Base;
include (__DIR__ . '/Lib/func.php');

/**
 * @abstract
 * @author    LunnLew <lunnlew@gmail.com>
 */
abstract class Stor extends Base {
	/**
	 * 构造函数
	 */
	final public function __construct() {
		$this->cfg = include (__DIR__ . '/Api/baidu.stor.php');
	}
}