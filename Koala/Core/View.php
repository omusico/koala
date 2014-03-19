<?php
defined('IN_Koala') or exit();
class View extends Initial{
	static $engine = null;
	//设置视图引擎
	public function setEngine($type,$option){
		$class = 'Engine_'.$type;
		self::$engine = new $class($option);
	}
	/**
	 * 注册变量
	 * @param  string $key
	 * @param  mixed $value
	 */
	public static function assign($key,$value){
		return self::$engine->assign($key,$value);
	}
	/**
	 * 模板输出
	 * @param  string $tpl 模板名
	 */
	public static function show($tpl=''){
		return self::$engine->show($tpl);
	}
	/**
	 * 模板输出
	 * @param  string $tpl 模板名
	 */
	public static function display($tpl=''){
		return self::$engine->display($tpl);
	}
	/**
	 * 返回模板
	 * @param  string $tpl 模板名
	 */
	public static function fetch($tpl=''){
		return self::$engine->fetch($tpl);
	}
}