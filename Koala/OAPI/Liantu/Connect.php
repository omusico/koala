<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\OAPI\Liantu;
use Core\Request\BaseV1 as RequestBase;

/**
 * 联图网 二维码 api
 *
 * http://www.liantu.com/pingtai/
 */
class Connect extends RequestBase {
	/**
	 * 构造函数
	 */
	final public function __construct() {
		$this->cfg = include (__DIR__ . '/Api/liantu.php');
	}
}