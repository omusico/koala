<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
/**
 * 前端数据收集器
 *
 * @package  Koala
 * @subpackage  Server
 * @author    LunnLew <lunnlew@gmail.com>
 */
class FrontData {
	/**
	 * 设置数据项
	 * @param  string $key   数据key
	 * @param  fixed $value  数据值
	 * @return bool          操作结果true,false
	 */
	public static function assign($key, $value) {
		return Koala\Server\Collection::factory('Front')->set($key, $value);
	}
	/**
	 * 获取数据项
	 * @param  string $key   数据key
	 * @param  fixed $value  数据默认值
	 * @return fixed         数据值
	 */
	public static function get($key, $value = '') {
		return Koala\Server\Collection::factory('Front')->get($key, $value);
	}
	/**
	 * 取消数据项
	 * @param  string $key   数据key
	 * @return bool          操作结果true,false
	 */
	public static function recede($key, $value) {
		return Koala\Server\Collection::factory('Front')->remove($key);
	}
	/**
	 * 获取所有数据
	 * @return array
	 */
	public static function getAll() {
		return Koala\Server\Collection::factory('Front')->all();
	}
	/**
	 * 数据转为json串
	 * @return string json串
	 */
	public static function toJson() {
		return json_encode(Koala\Server\Collection::factory('Front')->all());
	}
}