<?php
/**
 * 支付服务
 */
class Payment{
    /**
    * 操作句柄数组
    * @var array
    */
    static protected $handlers = array();
	public function __construct(){}
	public static function factory($type=''){
		if(empty($type)||!is_string($type)){
			$type = C('Payment:DEFAULT','LAEPayment');
		}
		if(!isset(self::$handlers[$type])){
			self::$handlers[$type] = Server\Payment\Factory::getInstance($type,C('Payment:'.$type));
		}
		return self::$handlers[$type];
	}
	
}