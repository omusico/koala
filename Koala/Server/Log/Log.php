<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\Server;
/**
 * Controller服务类
 *
 * @package  Koala
 * @subpackage  Server
 * @author    LunnLew <lunnlew@gmail.com>
 */
class Log {
	/**
	 * 服务驱动实例数组
	 * @var array
	 * @static
	 * @access protected
	 */
	protected static $instances = array();
	/**
	 * 详细调试信息
	 */
	const DEBUG = 100;

	/**
	 * 关键信息
	 */
	const INFO = 200;

	/**
	 * 一般通知
	 */
	const NOTICE = 250;

	/**
	 * 警告
	 */
	const WARNING = 300;

	/**
	 * 错误
	 */
	const ERROR = 400;

	/**
	 * 建议
	 */
	const CRITICAL = 500;

	/**
	 * 要求
	 */
	const ALERT = 550;

	/**
	 * 紧急
	 */
	const EMERGENCY = 600;

	/**
	 * API 版本
	 *
	 * 例如Monolog
	 *
	 * @var int
	 */
	const API = 1;
	/**
	 * 服务实例化函数
	 *
	 * @param  string $name    驱动名
	 * @param  array  $options 驱动构造参数
	 * @static
	 * @return object          驱动实例
	 */
	public static function factory($name = '', $options = array()) {
		if (empty($name) || !is_string($name)) {
			$name = C('Log:default', 'Monolog');
		}
		if (!isset(self::$instances[$name])) {
			$c_options = C('Log:' . $name);
			if (empty($c_options)) {
				$c_options = array();
			}
			$options = array_merge($c_options, $options);
			self::$instances[$name] = Log\Factory::getInstance($name, $options);
		}
		return self::$instances[$name];
	}
}