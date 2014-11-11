<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
/**
 * 配置操作类
 *
 * @package  Koala
 * @author    LunnLew <lunnlew@gmail.com>
 */
class Config {
	/**
	 * 配置项
	 */
	static $config = array();
	/**
	 * 加载配置
	 * @param  string $file_path 配置文件路路径
	 */
	public static function loadFile($file_path) {
		self::$config = array_merge(self::$config, require ($file_path));
	}
	/**
	 * 获得配置项
	 * @param  string $key    配置项,如group:list,Engine:smarty:param,注意key中第二个子项必须小写
	 * @param  string $config 配置数组
	 * @param  bool $runtime  运行时设置 true/false
	 * @return fixed          配置项值
	 */
	public static function getItem($key, $defv = '', $runtime = false) {
		if ($runtime && $defv != '') {
			return (self::$config[$key] = $defv);
		}
		if (null === ($val = getValueRec(explode(':', $key), self::$config))) {
			$result = $defv;
		} else {
			$result = $val;
		}

		if (strripos($key, 'list') === (strlen($key) - 4)) {
			$result = explode(',', $result);
		}

		return $result;
	}
	/**
	 * 获得配置项
	 * @param  array $keys   配置项数组
	 * @param  array $defvs 配置数组
	 * @param  bool $runtime  运行时设置 true/false
	 * @return fixed          配置项值数组
	 */
	public static function getItems($keys, $defvs = array(), $runtime = false) {
		if ($runtime && !empty($defvs)) {
			return $defvs;
		}
		$cfgs = array();
		if (is_string($keys)) {
			//字符参数默认以,号作为间隔符
			$keyArr = explode(',', $keys);
		} elseif (is_array($keys)) {
			$keyArr = $keys;
		} else {
			return array();
		}
		foreach ($keyArr as $key => $value) {
			$cfgs[$value] = isset(self::$config[$value]) ? self::$config[$value] : $defvs[$value];
		}
		return $cfgs;
	}
}