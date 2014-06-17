<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\Server;
/**
 * ErrorHandler服务类
 * 
 * @package  Koala
 * @subpackage  Server
 * @author    LunnLew <lunnlew@gmail.com>
 */
class ErrorHandler{
  	/**
   	* 服务驱动实例数组
   	* @var array
   	* @static
   	* @access protected
   	*/
  	protected static $instances = array();
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
			$name = C('ErrorHandler:default','ErrorHandler');
		}
		if(!isset(self::$instances[$name])){
			$c_options = C('ErrorHandler:'.$name);
			if(empty($c_options)){
				$c_options = array();
			}
			$options = array_merge($c_options,$options);
			$class = ErrorHandler\Factory::getServerName($name);
			self::$instances[$name] = call_user_func_array("$class::register",$options);
		}
		return self::$instances[$name];
	}
	/**
  	 * 注册句柄
  	 * 
  	 * @param  string $name    驱动名
  	 * @param  array  $options 驱动构造参数
  	 * @param  Closure  $closure 闭包函数
  	 * @static
  	 */
	public static function register($name='',$options=array(),\Closure $closure){
		$errorhandler = self::factory($name,$options);
		$closure($errorhandler);
	}
}