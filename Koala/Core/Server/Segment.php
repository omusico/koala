<?php
/**
 * 
 *分词服务
 *
 */
class Segment{
	static $objects = null;
  	public function __construct(){}
	public static function factory($type=''){
	    if(empty($type)||!is_string($type)){
	      $type = C('Segment:DEFAULT','LAESegment');
	    }
	    if(!isset(self::$objects[$type])){
	      self::$objects[$type] = Server\Segment\Factory::getInstance($type,C('Segment:'.$type));
	    }
	    return self::$objects[$type];
	 }
}