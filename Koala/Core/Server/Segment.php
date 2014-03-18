<?php
/**
 * 
 *分词服务API支持
 *
 */
class Segment{
	static $objects = null;
  	static $type = 'Segment';
  	public function __construct(){}
	public static function factory($type=''){
	    if(empty($type)||!is_string($type)){
	      $type = C('Segment:DEFAULT','LAESegment');
	    }
	    if(!isset(self::$objects[$type])){
	      self::$objects[$type] = Server_Segment_Factory::getInstance($type,C('Segment:'.$type));
	    }
	    return self::$objects[$type];
	 }
}