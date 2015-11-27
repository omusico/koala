<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\Server\Db;
/**
 * 工厂类
 *
 * @package  Koala
 * @subpackage  Server\Db
 * @author    LunnLew <lunnlew@gmail.com>
 */
class Factory extends \Koala\Server\Factory {
	/**
	 * 获得服务驱动实例
	 *
	 * @param  string $name 服务驱动名
	 * @param  array  $option 配置数组
	 * @final
	 * @static
	 * @return object  实例
	 */
	final public static function getInstance($name, $option = array(), $prex = 'Koala') {
		$class = static::getServerName($name, $prex);
		if (class_exists($class)) {
			return new $class($option);
		} else {
			return null;
		}
	}
	/**
	 * 组装完整服务类名
	 *
	 * @param  string $name 服务驱动名
	 * @param  string $prex  类名前缀
	 * @static
	 * @return string              完整服务驱动类名
	 */
	public static function getServerName($name, $prex = '') {
		$name = RUN_ENGINE . ucfirst($name);
		return self::getApiName('Db', $name);
	}
}