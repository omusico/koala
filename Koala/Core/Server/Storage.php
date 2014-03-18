<?php
/**
 * 
 *对不同云计算平台的Storage服务API支持
 *
 */
class Storage{
  static $objects = null;
  public function __construct(){}
  public static function factory($type=''){
    if(empty($type)||!is_string($type)){
      $type = C('Storage:DEFAULT','LAEStorage');
    }
    if(!isset(self::$objects[$type])){
      self::$objects[$type] = Server_Storage_Factory::getInstance($type,C('Storage:'.$type));
    }
    return self::$objects[$type];
  }
}