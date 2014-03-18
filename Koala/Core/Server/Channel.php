<?php
defined('IN_Koala') or exit();
/**
 * 
 *对不同云计算平台的Channel服务API支持
 *
 */
class Channel{
	static $objects = null;
	static $type = 'Channel';
	public function __construct(){}
	public static function factory($type=''){
		if(empty($type)||!is_string($type)){
			$type = C('Channel:DEFAULT','Channel');
		}
		if(!isset(self::$objects[$type])){
			self::$objects[$type] = Core_Cache_Factory::getInstance($type,C('Channel:'.$type));
		}
		return $objects[$type];
	}
}