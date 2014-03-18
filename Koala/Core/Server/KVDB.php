<?php
defined('IN_Koala') or exit();
/**
 * 
 *对不同云计算平台的KVDB服务API支持
 *
 */
class KVDB{
	static $objects = null;
	static $type = 'KVDB';
	public function __construct(){}
	public static function factory($type=''){
		if(empty($type)||!is_string($type)){
			$type = C('KVDB:DEFAULT','KVDB');
		}
		if(!isset(self::$objects[$type])){
			self::$objects[$type] = Core_Cache_Factory::getInstance($type,C('KVDB:'.$type));
		}
		return $objects[$type];
	}
}