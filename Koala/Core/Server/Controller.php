<?php
/**
 * Controller
 */
class Controller{
  	/**
   	* 操作句柄数组
   	* @var array
   	*/
  	static protected $handlers = array();
	public function __construct(){}
	public static function factory($type='',$options=array()){
		if(empty($type)||!is_string($type)){
			$type = C('Controller:DEFAULT','Controller');
		}
		if(!isset(self::$handlers[$type])){
			$c_options = C('Controller:'.$type);
			if(empty($c_options)){
				$c_options = array();
			}
			$options = array_merge($c_options,$options);
			self::$handlers[$type] = Server\Controller\Factory::getInstance($type,$options);
		}
		return self::$handlers[$type];
	}
}