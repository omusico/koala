<?php
/**
 * 
 *Channel服务
 *
 */
class Channel{
  	/**
   	* 操作句柄数组
   	* @var array
   	*/
  	static protected $handlers = array();
	public function __construct(){}
	public static function factory($type=''){
		if(empty($type)||!is_string($type)){
			$type = C('Channel:DEFAULT','LAEChannel');
		}
		if(!isset(self::$handlers[$type])){
			self::$handlers[$type] = Server_Channel_Factory::getInstance($type,C('Channel:'.$type));
		}
		return self::$handlers[$type];
	}
}