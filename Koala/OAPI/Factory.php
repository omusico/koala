<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\OAPI;
/**
 * 工厂类
 *
 * @package  Koala
 * @subpackage  Server\OAPI
 * @author    LunnLew <lunnlew@gmail.com>
 */
class Factory implements \ApiInterface {

	static $tpl = '\OAPI\%s';
	/**
	 * 获得服务驱动实例
	 *
	 * @param  string $name 服务驱动名
	 * @param  array  $option 配置数组
	 * @final
	 * @static
	 * @return object  实例
	 */
	public static function getInstance($name, $option = array(), $prex = 'Koala') {

		$class = static::getApiName($name, '',$prex);

		if (class_exists($class)) {
			return new $class($option);
		} else {
			throw new \Koala\Exception\RuntimeException('服务[' . $class . ']类未找到!');
		}
	}
	/**
	 * 组装完整服务类名
	 *
	 *  @param  string $server_name 服务驱动名
	 * @param  string $prex  类名前缀
	 * @access protected
	 * @static
	 * @return string              完整服务驱动类名
	 */
	public static function getApiName($classify, $name,$prex='Koala'){
		return vsprintf($prex.self::$tpl,array($classify,$name));
	}
}