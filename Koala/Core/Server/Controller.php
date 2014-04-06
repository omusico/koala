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
	public static function factory($type=''){
		if(empty($type)||!is_string($type)){
			$type = C('Controller:DEFAULT','Controller');
		}
		if(!isset(self::$handlers[$type])){
			self::$handlers[$type] = Server\Controller\Factory::getInstance($type,C('Controller:'.$type));
		}
		return self::$handlers[$type];
	}
}