<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   Lunnlew <Lunnlew@gmail.com>
 */
/**
 * 前端数据收集器
 * 
 * @package  Koala
 * @subpackage  Server
 * @author    Lunnlew <Lunnlew@gmail.com>
 */
class FrontData{
    protected static $alert = -1;
    protected static $msg = '';
    public static function assign($key,$value){
        return Collection::factory('Front')->set($key,$value);
    }
    public static function get($key,$value=''){
        return Collection::factory('Front')->get($key,$value);
    }
    public static function toJson(){
        return json_encode(Collection::factory('Front')->all());
    }
    public static function getAll(){
       return Collection::factory('Front')->all();
    }
    public static function error($msg){
      self::$alert = 0;
      self::$msg=$msg;
    }
    public static function success($msg){
      self::$alert = 1;
      self::$msg=$msg;
    }
    public static function info($msg){
      self::$alert = 2;
      self::$msg=$msg;
    }
    public static function getAlert(){
      return self::$alert;
    }
    public static function getMsg(){
      return self::$msg;
    }
}