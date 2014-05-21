<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\Server;
/**
 * 分词服务类
 * 
 * @package  Koala
 * @subpackage  Server
 * @author    LunnLew <lunnlew@gmail.com>
 */
class Segment{
  	/**
   	* 服务驱动实例数组
   	* @var array
   	* @static
   	* @access protected
   	*/
  	protected static $instances = array();
  	/**
  	 * 服务实例化函数
  	 * 
  	 * @param  string $name    驱动名
  	 * @param  array  $options 驱动构造参数
  	 * @static
  	 * @return object          驱动实例
  	 */
	public static function factory($name='',$options=array()){
	    if(empty($name)||!is_string($name)){
    			$name = C('Segment:default','Segment');
    		}
    		if(!isset(self::$instances[$name])){
    			$c_options = C('Segment:'.$name);
    		if(empty($c_options)){
    		    $c_options = array();
    		}
    			$options = array_merge($c_options,$options);
    			self::$instances[$name] = Segment\Factory::getInstance($name,$options);
    		}
	    return self::$instances[$name];
	 }
}