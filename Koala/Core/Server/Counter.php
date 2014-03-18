<?php
class Counter{
	static $objects = null;
	static $type = 'Counter';
	public function __construct(){}
	public static function factory($type=''){
		if(empty($type)||!is_string($type)){
			$type = C('Counter:DEFAULT','Counter');
		}
		if(!isset(self::$objects[$type])){
			self::$objects[$type] = Core_Counter_Factory::getInstance($type,C('Counter:'.$type));
		}
		return $objects[$type];
	}
}

class Counter{
	static $object = null;
	public static function __callStatic($method,$args){
		if(self::$object==''){
			self::$object = Server::getInstance('Counter');
		}
		if(method_exists(self::$object, $method)){
			$res = call_user_func_array(array(self::$object,$method),$args);
			return $res;
		}
		return null;
	}
	//建立一个计数器
	public static function create(){
		$m = explode('::',__METHOD__);
    	$p = func_get_args();
    	return self::__callStatic($m[1],$p);
	}
	//移除一个计数器
	public static function remove(){
		$m = explode('::',__METHOD__);
    	$p = func_get_args();
    	return self::__callStatic($m[1],$p);
	}
	//获得某项的值
	public static function get(){
		$m = explode('::',__METHOD__);
    	$p = func_get_args();
    	return self::__callStatic($m[1],$p);
	}
	//设置计数器的值
	public static function set(){
		$m = explode('::',__METHOD__);
    	$p = func_get_args();
    	return self::__callStatic($m[1],$p);
	}
	//获得多个计数器的值
	public static function mget(){
		$m = explode('::',__METHOD__);
    	$p = func_get_args();
    	return self::__callStatic($m[1],$p);
	}
	//设置多个计数器的值
	public static function mset(){
		$m = explode('::',__METHOD__);
    	$p = func_get_args();
    	return self::__callStatic($m[1],$p);
	}
	//对计数器减
	public static function decrease(){
		$m = explode('::',__METHOD__);
    	$p = func_get_args();
    	return self::__callStatic($m[1],$p);
	}
	//对计数器加
	public static function increase(){
		$m = explode('::',__METHOD__);
    	$p = func_get_args();
    	return self::__callStatic($m[1],$p);
	}
	//获得计数器列表
	public static function getAllList(){
		$m = explode('::',__METHOD__);
    	$p = func_get_args();
    	return self::__callStatic($m[1],$p);
	}
  	//判断计数器是否存在
	public static function isExist(){
		$m = explode('::',__METHOD__);
    	$p = func_get_args();
    	return self::__callStatic($m[1],$p);
	}
	//获得计数器数量
	public static function getNums(){
		$m = explode('::',__METHOD__);
    	$p = func_get_args();
    	return self::__callStatic($m[1],$p);
	}
}
?>