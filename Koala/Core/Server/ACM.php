<?php
/**
 * 
 *访问控制服务
 *
 */
class ACM{
  	/**
   	* 操作句柄数组
   	* @var array
   	*/
  	static protected $handlers = array();
	public function __construct(){}
	public static function factory($type=''){
		if(empty($type)||!is_string($type)){
			$type = C('ACM:DEFAULT','ACM');
		}
		if(!isset(self::$handlers[$type])){
			self::$handlers[$type] = Server\ACM\Factory::getInstance($type,C('ACM:'.$type));
		}
		return self::$handlers[$type];
	}
}