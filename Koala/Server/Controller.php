<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   Lunnlew <Lunnlew@gmail.com>
 */
/**
 * Controller服务类
 * 
 * @package  Koala
 * @subpackage  Server
 * @author    Lunnlew <Lunnlew@gmail.com>
 */
class Controller{
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
			$name = C('Controller:DEFAULT','Controller');
		}
		if(!isset(self::$handlers[$name])){
			$c_options = C('Controller:'.$name);
			if(empty($c_options)){
				$c_options = array();
			}
			$options = array_merge($c_options,$options);
			self::$handlers[$name] = Server\Controller\Factory::getInstance($name,$options);
		}
		return self::$handlers[$name];
	}
	/**
	 * 自定义控制器加载方案
	 * 
	 * @param  String/Closure $closure 闭包函数 默认为空
	 * @return 
	 */
	public function register($closure=null){
		if($closure==null){
			ClassLoader::initialize(function($instance){
		        //注册_autoload函数
			    $instance->register();
			    $instance->registerNamespaces(array(
			        'Controller' => APP_PATH));
			});
		}else{
			$closure();
		}
	}
}