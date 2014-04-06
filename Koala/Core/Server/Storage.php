<?php
/**
 * 
 *存储服务
 *
 */
class Storage{
  /**
   * 操作句柄数组
   * @var array
   */
  static protected $handlers = array();
    public function __construct(){}
    public static function factory($type='',$options=array()){
      if(empty($type)||!is_string($type)){
        $type = C('Storage:DEFAULT','LAEStorage');
      }
      if(!isset(self::$handlers[$type])){
        $c_options = C('Storage:'.$type);
        if(empty($c_options)){
            $c_options = array();
        }
        $options = array_merge($c_options,$options);
        self::$handlers[$type] = Server\Storage\Factory::getInstance($type,$options);
      }
      return self::$handlers[$type];
    }
}