<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala;
/**
 * OAPI
 *
 * @package  Koala
 * @subpackage  Server
 * @author    LunnLew <lunnlew@gmail.com>
 */
class OAPI {
	/**
	 * 服务驱动实例数组
	 * @var array
	 * @static
	 * @access protected
	 */
	protected static $instances = array();
	/**
	 * 服务实例化函数
	 *
	 * @param  string $name    驱动名
	 * @param  array  $options 驱动构造参数
	 * @static
	 * @return object          驱动实例
	 */
	public static function factory($name, $options = array(), $prex = 'Koala') {
		$parts = explode('\\', __CLASS__);
		$server_name = array_pop($parts);
		if (empty($name) || !is_string($name)) {
			exit('OAPI ERROR!');
		}
		if (!isset(self::$instances[$name])) {
			$fac = __CLASS__ . '\Factory';
			self::$instances[$name] = $fac::getInstance($name, array_merge((Array) C($server_name . ':' . $name), (Array) $options), $prex);
		}
		return self::$instances[$name];
	}
}