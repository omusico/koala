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
  public static function factory($type=''){
    if(empty($type)||!is_string($type)){
      $type = C('Storage:DEFAULT','LAEStorage');
    }
    if(!isset(self::$handlers[$type])){
      self::$handlers[$type] = Server\Storage\Factory::getInstance($type,C('Storage:'.$type));
    }
    return self::$handlers[$type];
  }
}