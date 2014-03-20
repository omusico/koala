<?php
class Counter{
	static $objects = null;
	public function __construct(){}
	public static function factory($type=''){
		if(empty($type)||!is_string($type)){
			$type = C('Counter:DEFAULT','LAECounter');
		}
		if(!isset(self::$objects[$type])){
			self::$objects[$type] = Server_Counter_Factory::getInstance($type,C('Counter:'.$type));
		}
		return self::$objects[$type];
	}
}