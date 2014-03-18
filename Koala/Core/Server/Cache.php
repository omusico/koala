<?php
//缓存
class Cache{
	static $objects = null;
	public function __construct(){}
	public static function factory($type=''){
		if(empty($type)||!is_string($type)){
			$type = C('CACHE:DEFAULT','LAEMemcache');
		}
		if(!isset(self::$objects[$type])){
			self::$objects[$type] = Server_Cache_Factory::getInstance($type,C('CACHE:'.$type));
		}
		return self::$objects[$type];
	}
}