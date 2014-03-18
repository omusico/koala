<?php
class Counter{
	static $objects = null;
	static $type = 'Counter';
	public function __construct(){}
	public static function factory($type=''){
		if(empty($type)||!is_string($type)){
			$type = C('Counter:DEFAULT','Counter');
		}
		if(!isset(self::$objects[$type])){
			self::$objects[$type] = Core_Counter_Factory::getInstance($type,C('Counter:'.$type));
		}
		return $objects[$type];
	}
}