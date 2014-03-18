<?php
/**
 * 
 *对不同云计算平台的Channel服务API支持
 *
 */
class Channel{
	static $objects = null;
	public function __construct(){}
	public static function factory($type=''){
		if(empty($type)||!is_string($type)){
			$type = C('Channel:DEFAULT','LAEChannel');
		}
		if(!isset(self::$objects[$type])){
			self::$objects[$type] = Server_Channel_Factory::getInstance($type,C('Channel:'.$type));
		}
		return self::$objects[$type];
	}
}