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
	public static function factory($type='',$option=array()){
		if(empty($type)||!is_string($type)){
			$type = C('Channel:DEFAULT','LAEChannel');
		}
		if(!isset(self::$handlers[$type])){
			$c_options = C('Channel:'.$type);
			if(empty($c_options)){
				$c_options = array();
			}
			$options = array_merge($c_options,$options);
			self::$handlers[$type] = Server\Channel\Factory::getInstance($type,$options);
		}
		return self::$handlers[$type];
	}
}