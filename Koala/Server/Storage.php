<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   Lunnlew <Lunnlew@gmail.com>
 */
/**
 * Storage服务类
 * 
 * @package  Koala
 * @subpackage  Server
 * @author    Lunnlew <Lunnlew@gmail.com>
 */
class Storage{
  	/**
   	* 操作句柄数组
   	* @var array
   	* @static
   	* @access protected
   	*/
  	protected static $handlers = array();
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
			$name = C('Storage:DEFAULT','LAEStorage');
		}
		if(!isset(self::$handlers[$name])){
			$c_options = C('Storage:'.$name);
		if(empty($c_options)){
		    $c_options = array();
		}
			$options = array_merge($c_options,$options);
			self::$handlers[$name] = Server\Storage\Factory::getInstance($name,$options);
		}
	    return self::$objects[$name];
	 }
}