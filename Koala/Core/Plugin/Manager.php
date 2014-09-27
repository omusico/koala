<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Core\Plugin;
class Manager {
	//已注册的插件监听表
	private static $_queues = array();
	private static $_onlys = array();
	//插件参数
	private static $_params = array();
	/**
	 * 插件挂载
	 * @param  string $hook     挂载点
	 * @param  mixd $callable 可调用的参数
	 */
	public static function prepend($hook, $callable, $param = null) {
		array_unshift(self::$_queues[$hook], $callable);
		self::$_params[$hook][self::callableToStr($callable)] = $param;
	}
	/**
	 * 插件挂载
	 * @param  string $hook     挂载点
	 * @param  mixd $callable 可调用的参数
	 */
	public static function append($hook, $callable, $param = null) {
		self::$_queues[$hook][] = $callable;
		self::$_params[$hook][self::callableToStr($callable)] = $param;
	}
	/**
	 * 插件挂载
	 * @param  string $hook     挂载点
	 * @param  mixd $callable 可调用的参数
	 */
	public static function register($hook, $callable, $param = null) {
		self::$_queues[$hook][] = $callable;
		self::$_params[$hook][self::callableToStr($callable)] = $param;
	}
	/**
	 * 插件挂载
	 * @param  string $hook     挂载点
	 * @param  mixd $callable 可调用的参数
	 */
	public static function only($hook, $callable, $param = null) {
		self::$_onlys[$hook] = $callable;
		self::$_params[$hook][self::callableToStr($callable)] = $param;
	}
	/**
	 * 挂载点触发器
	 * @param  string $hook     挂载点
	 * @param  fixd $callable 触发指定的callable
	 * @return [type]       [description]
	 */
	public static function trigger($hook, $param = null, $callable = null, $return = false) {
		//指定callable
		if (!empty($callable) || isset(self::$_onlys[$hook])) {
			empty($callable) && ($callable = self::$_onlys[$hook]);
			//hash
			$string = self::callableToStr($callable);
			//合并参数
			if (is_string($param) || $param == null) {
				$param = array($param);
			}
			if (isset(self::$_params[$hook][$string])) {
				$param = array_merge(self::$_params[$hook][$string], $param);
			}
			return call_user_func_array($callable, $param);
		}
		$param = array($param);
		//查看要实现的钩子，是否在监听数组之中
		if (!empty(self::$_queues[$hook])) {
			//遍历所有
			foreach (self::$_queues[$hook] as $callable) {
				$r = call_user_func_array($callable, $param);
				if ($return) {return $r;
				}
			}
		}
	}

	/**
	 * [callableToStr description]
	 * @param  [type] $callable [description]
	 * @return [type]           [description]
	 */
	public static function callableToStr($callable) {
		if (is_array($callable)) {
			if (is_object($callable[0])) {
				$string = get_class($callable[0]) . $callable[1];
			} else {
				$string = implode('', $callable);
			}
		} else {
			$string = $callable;
		}
		return $string;
	}
	/**
	 * 加载插件
	 */
	public static function loadPlugin($path, $pre = 'Koala', $dir = 'Addons') {
		$path = rtrim($path, '/') . '/';
		if (!file_exists($path)) {return;}
		//遍历插件
		$handle = opendir($path);
		if ($handle) {
			while ($file = readdir($handle)) {
				if ($file == '.' || $file == '..') {
					continue;
				}
				$newpath = $path . $file;
				if (is_dir($newpath)) {
					$class = $pre . '\\' . $dir . '\\' . $file . '\\Action';
					new $class();
				}
			}
		}
	}
}
