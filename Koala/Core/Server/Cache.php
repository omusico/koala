<?php
/**
 * 缓存服务
 */
class Cache{
  	/**
   	* 操作句柄数组
   	* @var array
   	*/
  	static protected $handlers = array();
	public function __construct(){}
	public static function factory($type=''){
		if(empty($type)||!is_string($type)){
			$type = C('CACHE:DEFAULT','LAEMemcache');
		}
		if(!isset(self::$handlers[$type])){
			self::$handlers[$type] = Server\Cache\Factory::getInstance($type,C('CACHE:'.$type));
		}
		return self::$handlers[$type];
	}
}