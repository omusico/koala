<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\OAPI\Org;
use Koala\OAPI\Base;

/**
 * 矩网智慧 分词服务
 *http://www.vapsec.com/fenci/
 * @abstract
 * @author    LunnLew <lunnlew@gmail.com>
 */
abstract class Segment extends Base {
	/**
	 * 获取token
	 * @param  string $str [description]
	 * @return mixed
	 */
	abstract protected function _getToken($str = '');
}