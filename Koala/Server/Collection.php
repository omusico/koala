<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   Lunnlew <Lunnlew@gmail.com>
 */
/**
 * 数据收集器服务类
 * 
 * @package  Koala
 * @subpackage  Server
 * @author    Lunnlew <Lunnlew@gmail.com>
 */
class Collection{
    /**
    * 操作句柄数组
    * @var array
    * @access protected
    */
    protected static $handlers = array();
    /**
     * 访问控制实例化函数
     * 
     * @param  string $name    驱动名
     * @param  array  $options 驱动构造参数
     * @param  boolean $new    是否初始化新实例 默认false
     * @return object          驱动实例
     */
	public static function factory($name='',$options=array(),$new=false){
        if(empty($name)||!is_string($name)){
            $name = C('Collection:DEFAULT','data');
        }
        if($new || !isset(self::$handlers[$name])){
            $c_options = C('Collection:'.$name);
            if(empty($c_options)){
                $c_options = array();
            }
            $options = array_merge($c_options,$options);
            self::$handlers[$name] = Server\Collection\Factory::getInstance($name,$options);
        }
        return self::$handlers[$name];
    }
}