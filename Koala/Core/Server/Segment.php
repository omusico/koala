<?php
defined('IN_Koala') or exit();
/**
 * 
 *分词服务API支持
 *
 */
class Segment{
	static $object = null;
	public static function __callStatic($method,$args){
		if(self::$object==''){
			self::$object = Server::getInstance('Segment');
		}
		if(method_exists(self::$object, $method)){
			$res = call_user_func_array(array(self::$object,$method),$args);
			return $res;
		}
		return null;
	}
}
?>