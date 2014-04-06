<?php
/**
 * 
 *分词服务
 *
 */
class Segment{
	static $objects = null;
  	public function __construct(){}
	public static function factory($type='',$options=array()){
	    if(empty($type)||!is_string($type)){
	      $type = C('Segment:DEFAULT','LAESegment');
	    }
	    if(!isset(self::$objects[$type])){
	    	$c_options = C('Segment:'.$type);
        if(empty($c_options)){
            $c_options = array();
        }
        $options = array_merge($c_options,$options);
	      self::$objects[$type] = Server\Segment\Factory::getInstance($type,C('Segment:'.$type));
	    }
	    return self::$objects[$type];
	 }
}