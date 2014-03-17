<?php
//缓存
class Cache{
	static $objects = null;
	static $type = 'Memcache';
	public function __construct(){}
	public static function factory($type=''){
		if(empty($type)||!is_string($type)){
			$type = C('CACHE:DEFAULT','Memcache');
		}
		if(!isset(self::$objects[$type])){
			self::$objects[$type] = Core_Cache_Factory::getInstance($type,C('CACHE:'.$type));
		}
		return $objects[$type];
	}
	public static function __callStatic($method,$args){
		if(method_exists(self::$objects[self::$type], $method)){
			$res = call_user_func_array(array(self::$objects[self::$type],$method),$args);
			return $res;
		}
		return false;
	}
}