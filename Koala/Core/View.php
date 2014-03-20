<?php
defined('IN_Koala') or exit();
class View extends Initial{
	static $engine = null;
	//设置视图引擎
	public function setEngine($type,$option){
		$class = 'Engine_'.$type;
		self::$engine = $class::factory($option);
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
		if(empty($tpl)){
			$pre = MODULE_NAME.'/page/';
			$tpl = ACTION_NAME;
		}else{
			$pre = '';
		}
		return self::$engine->display($pre.$tpl.'.html');
	}
	/**
	 * 模板输出
	 * @param  string $tpl 模板名
	 */
	public static function display($tpl=''){
		if(empty($tpl)){
			$pre = GROUP_NAME.'/'.MODULE_NAME.'/page/';
			$tpl = ACTION_NAME;
		}else{
			$pre = '';
		}
		return self::$engine->display($pre.$tpl.'.html');
	}
	/**
	 * 返回模板
	 * @param  string $tpl 模板名
	 */
	public static function fetch($tpl=''){
		if(empty($tpl)){
			$pre = GROUP_NAME.'/'.MODULE_NAME.'/page/';
			$tpl = ACTION_NAME;
		}else{
			$pre = '';
		}
		return self::$engine->fetch($pre.$tpl.'.html');
	}
}