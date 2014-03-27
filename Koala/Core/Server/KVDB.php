<?php
/**
 * 
 *KVDB服务
 *
 */
class KVDB{
  	/**
   	* 操作句柄数组
   	* @var array
   	*/
  	static protected $handlers = array();
	public function __construct(){}
	public static function factory($type=''){
		if(empty($type)||!is_string($type)){
			$type = C('KVDB:DEFAULT','LAEKVDB');
		}
		if(!isset(self::$handlers[$type])){
			self::$handlers[$type] = Server_KVDB_Factory::getInstance($type,C('KVDB:'.$type));
		}
		return self::$handlers[$type];
	}
}