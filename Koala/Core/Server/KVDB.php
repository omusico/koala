<?php
/**
 * 
 *对不同云计算平台的KVDB服务API支持
 *
 */
class KVDB{
	static $objects = null;
	public function __construct(){}
	public static function factory($type=''){
		if(empty($type)||!is_string($type)){
			$type = C('KVDB:DEFAULT','LAEKVDB');
		}
		if(!isset(self::$objects[$type])){
			self::$objects[$type] = Server_KVDB_Factory::getInstance($type,C('KVDB:'.$type));
		}
		return self::$objects[$type];
	}
}