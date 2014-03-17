<?php
defined('IN_Koala') or exit();
/**
 * 
 *对不同云计算平台的Cache服务API支持
 *
 */
class Cache{
	static $object = null;
	public static function __callStatic($method,$args){
		if(self::$object==''){
			self::$object = Factory_Cache::getInstance();
		}
		if(method_exists(self::$object, $method)){
			$res = call_user_func_array(array(self::$object,$method),$args);
			return $res;
		}
		return null;
	}
}
?>