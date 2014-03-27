<?php
class Payment{
	static $objects = null;
	public function __construct(){}
	public static function factory($type=''){
		if(empty($type)||!is_string($type)){
			$type = C('Payment:DEFAULT','LAEPayment');
		}
		if(!isset(self::$objects[$type])){
			self::$objects[$type] = Server_Payment_Factory::getInstance($type,C('Payment:'.$type));
		}
		return self::$objects[$type];
	}
	
}