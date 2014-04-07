<?php
class ErrorHandler{
  	/**
   	* 操作句柄数组
   	* @var array
   	*/
  	static protected $handlers = array();
	public function __construct(){}
	public static function factory($type='',$options=array()){
		if(empty($type)||!is_string($type)){
			$type = C('ErrorHandler:DEFAULT','ErrorHandler');
		}
		if(!isset(self::$handlers[$type])){
			$c_options = C('ErrorHandler:'.$type);
			if(empty($c_options)){
				$c_options = array();
			}
			$options = array_merge($c_options,$options);
			$class = Server\ErrorHandler\Factory::getServerName($type);
			self::$handlers[$type] = call_user_func_array("$class::register",$options);
		}
		return self::$handlers[$type];
	}
}