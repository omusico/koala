<?php
//日志
class Log{
	static $objects = null;
	static $type = 'Log';
	public function __construct(){}
	public static function factory($type=''){
		if(empty($type)||!is_string($type)){
			$type = C('Log:DEFAULT','Log');
		}
		if(!isset(self::$objects[$type])){
			self::$objects[$type] = Core_Cache_Factory::getInstance($type,C('Log:'.$type));
		}
		return $objects[$type];
	}
}