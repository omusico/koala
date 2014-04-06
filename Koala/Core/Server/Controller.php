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
			if(!empty($options)){
				$cfg = C('Controller:'.$type);
				if(!empty($cfg))
				$options = array_merge($options,$cfg);
			}
			self::$handlers[$type] = Server\Controller\Factory::getInstance($type,$options);
		}
		return self::$handlers[$type];
	}
}