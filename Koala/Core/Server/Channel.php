<?php
defined('IN_Koala') or exit();
/**
 * 
 *对不同云计算平台的Channel服务API支持
 *
 */
class Channel{
	static $object = null;
	public static function __callStatic($method,$args){
		if(self::$object==''){
			self::$object = Server::getInstance('Channel');
		}
		if(method_exists(self::$object, $method)){
			$res = call_user_func_array(array(self::$object,$method),$args);
			return $res;
		}
		return null;
	}
	public static function createChannel(){
		$m = explode('::',__METHOD__);
    	$p = func_get_args();
    	return self::__callStatic($m[1],$p);
	}
    public static function sendMessage(){
    	$m = explode('::',__METHOD__);
    	$p = func_get_args();
    	return self::__callStatic($m[1],$p);
    }
}
?>