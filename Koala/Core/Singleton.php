<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
/**
 * 单例管理基类
 */
class Singleton {
	/**
	 * 单例实例索引数组
	 * @var array
	 */
	private static $instances = array();
	/**
	 * Closure 初始化支持
	 * @param  Closure $initializer Closure
	 * @param  array   $options      选项
	 */
	public static function initialize(Closure $initializer, $options = array()) {
		$initializer(self::getInstance(get_called_class()), $options);
	}
	/**
	 * 获得类单例
	 *
	 * @param  string $class 类名
	 * @param  bool   $new   是否新建实例(将覆盖原有实例)
	 * @return object        类单例
	 */
	public static function getInstance($class, $new = false) {
		if ($new
			 || !isset(self::$instances[$class])
			 || !is_object(self::$instances[$class])
		) {
			self::$instances[$class] = new $class();
		}
		return self::$instances[$class];
	}
	/**
	 * 设置单例
	 * @param string $class    class
	 * @param object $object 类实例
	 */
	public static function setInstance($class, $object) {
		if (is_object($object)) {
			self::$instances[$class] = $object;
			return true;
		}
		return false;
	}
	/**
	 * 移除类单例
	 * @param  string $class 类名
	 * @return
	 */
	public static function removeInstance($class) {
		if (isset(self::$instances[$class])) {
			unset(self::$instances[$class]);
		}
	}
}