<?php
defined('IN_Koala') or exit();
class View extends Initial{
	static $engine = null;
	//设置视图引擎
	public function setEngine($engine_name,$option=array()){
		self::$engine="Engine_".$engine_name;
		return call_user_func_array(array(self::$engine,'init'),$option);
	}
	/**
	 * 注册变量
	 * @param  string $key
	 * @param  mixed $value
	 */
	public static function assign($key,$value){
		return call_user_func(array(self::$engine,'assign'),$key,$value);
	}
	/**
	 * 模板输出
	 * @param  string $tpl 模板名
	 */
	public static function show($tpl=''){
		if(empty($tpl)){
			$tpl = MODULE_NAME.'/page/'.ACTION_NAME;
		}
		View::assign('tpl',$tpl);
		call_user_func(array(self::$engine,'display'),$tpl);exit;
		return 1;
	}
	/**
	 * 模板输出
	 * @param  string $tpl 模板名
	 */
	public static function display($tpl=''){
		View::assign('_SESSION',$_SESSION);
		if(empty($tpl)){
			$tpl = MODULE_NAME.'/page/'.ACTION_NAME;
		}
		if($tpl==C('TMPL_ACTION_SUCCESS')||$tpl==C('TMPL_ACTION_ERROR')){
			call_user_func(array(self::$engine,'display'),'Public/page/'.$tpl);exit;
		}else{
			call_user_func(array(self::$engine,'display'),$tpl);exit;
		}
		return 1;
	}
	/**
	 * 返回模板
	 * @param  string $tpl 模板名
	 */
	public static function fetch($tpl=''){
		if(empty($tpl)){
			$tpl = MODULE_NAME.'/page/'.ACTION_NAME;
		}
		return call_user_func(array(self::$engine,'fetch'),$tpl);
	}
	public static function get($name){
		return call_user_func(array(self::$engine,'get'),$name);
	}
	public static function error($msg){
		self::assign('error',$msg);
		self::display(C('TMPL_ACTION_ERROR'));
	}
	public static function success($msg){
		self::assign('message',$msg);
		self::display(C('TMPL_ACTION_SUCCESS'));
	}
}