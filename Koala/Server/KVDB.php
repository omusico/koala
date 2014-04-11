<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   Lunnlew <Lunnlew@gmail.com>
 */
/**
 * KVDB服务类
 * 
 * @package  Koala
 * @subpackage  Server
 * @author    Lunnlew <Lunnlew@gmail.com>
 */
class KVDB{
  	/**
   	* 操作句柄数组
   	* @var array
   	* @access protected
   	*/
  	protected static $handlers = array();
  	/**
  	 * 服务实例化函数
  	 * 
  	 * @param  string $name    驱动名
  	 * @param  array  $options 驱动构造参数
  	 * @return object          驱动实例
  	 */
	public static function factory($name='',$options=array()){
		if(empty($name)||!is_string($name)){
			$name = C('KVDB:DEFAULT','LAEKVDB');
		}
		if(!isset(self::$handlers[$name])){
			$c_options = C('KVDB:'.$name);
			if(empty($c_options)){
				$c_options = array();
			}
			$options = array_merge($c_options,$options);
			self::$handlers[$name] = Server\KVDB\Factory::getInstance($name,$options);
		}
		return self::$handlers[$name];
	}
}