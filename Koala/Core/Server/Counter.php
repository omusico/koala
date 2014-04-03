<?php
/**
 * Counter服务
 */
class Counter{
  	/**
   	* 操作句柄数组
   	* @var array
   	*/
  	static protected $handlers = array();
	public function __construct(){}
	public static function factory($type=''){
		if(empty($type)||!is_string($type)){
			$type = C('Counter:DEFAULT','LAECounter');
		}
		if(!isset(self::$handlers[$type])){
			self::$handlers[$type] = Server_Counter_Factory::getInstance($type,C('Counter:'.$type));
		}
		return self::$handlers[$type];
	}
}