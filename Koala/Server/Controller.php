<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   Lunnlew <Lunnlew@gmail.com>
 */
namespace Koala\Server;
/**
 * Controller服务类
 * 
 * @package  Koala
 * @subpackage  Server
 * @author    Lunnlew <Lunnlew@gmail.com>
 */
class Controller{
	static $loader;
	/**
	 * 自定义控制器加载方案
	 * 
	 * @param  String/Closure $closure 闭包函数 默认为空
	 * @static
	 * @return 
	 */
	public static function register($closure=null){
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