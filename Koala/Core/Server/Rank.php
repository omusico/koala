<?php
/**
 * 
 *Rank服务
 *
 */
class Rank{
    /**
    * 操作句柄数组
    * @var array
    */
    static protected $handlers = array();
	public function __construct(){}
	public static function factory($type=''){
		if(empty($type)||!is_string($type)){
			$type = C('Rank:DEFAULT','Rank');
		}
		if(!isset(self::$handlers[$type])){
			self::$handlers[$type] = Server\Rank\Factory::getInstance($type,C('Rank:'.$type));
		}
		return self::$handlers[$type];
	}
}