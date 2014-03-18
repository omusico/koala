<?php
defined('IN_Koala') or exit();
/**
 * 
 *对不同云计算平台的Rank服务API支持
 *
 */
class Rank{
	static $objects = null;
	public function __construct(){}
	public static function factory($type=''){
		if(empty($type)||!is_string($type)){
			$type = C('Rank:DEFAULT','Rank');
		}
		if(!isset(self::$objects[$type])){
			self::$objects[$type] = Server_Rank_Factory::getInstance($type,C('Rank:'.$type));
		}
		return self::$objects[$type];
	}
}