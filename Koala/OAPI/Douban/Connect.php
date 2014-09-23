<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\OAPI\Douban;
use Koala\OAPI\Base;
include (__DIR__ . '/Lib/func.php');

/**
 * @abstract
 * @author    LunnLew <lunnlew@gmail.com>
 */
abstract class Connect extends Base {
	/**
	 * 构造函数
	 */
	final public function __construct() {
		$this->cfg = include (__DIR__ . '/Api/connect.php');
	}
}