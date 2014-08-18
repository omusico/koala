<?php
/**
* Koala - A PHP Framework For Web
*
* @package  Koala
* @author   LunnLew <lunnlew@gmail.com>
*/
/**
* 插件管理类
*/
class Plugin{
	//已注册的插件监听表
	private static $_listeners = array();
	private static $_onlys = array();
	//插件参数
	private static $_params = array(); 
	//当前插件实例
	private static $_instance = null;
	/**
	* 插件挂载点注册
	* @param  string $hook     挂载点
	* @param  fixd $callable 可调用的参数
	* @return bool           注册结果
	*/
	public static function register($hook,$callable,$param=array()){
		self::$_listeners[$hook][] = $callable;
		self::$_params[$hook][self::hashCallable($callable)] = $param;
	}
	/**
	* 插件挂载点注册
	* @param  string $hook     挂载点
	* @param  fixd $callable 可调用的参数
	* @return bool           注册结果
	*/
	public static function only($hook,$callable,$param=array()){
		self::$_onlys[$hook] = $callable;
		self::$_params[$hook][self::hashCallable($callable)] = $param;
	}
	/**
	* 挂载点触发器
	* @param  string $hook     挂载点
	* @param  fixd $callable 触发指定的callable
	* @return [type]       [description]
	*/
	public  static function trigger($hook,$param=array(),$callable=null,$return=false){
		//指定callable
		if(!empty($callable)||isset(self::$_onlys[$hook])){
			empty($callable)&&($callable = self::$_onlys[$hook]);
			//hash
			$string = self::hashCallable($callable);
			//合并参数
			if(isset(self::$_params[$hook][$string]))
				$param = array(array_merge(self::$_params[$hook][$string],$param));
			return call_user_func_array($callable,$param);
		}
		$param =  array($param);
		//查看要实现的钩子，是否在监听数组之中 
		if (isset(self::$_listeners[$hook]) &&!empty(self::$_listeners[$hook])){
			//遍历所有
			foreach (self::$_listeners[$hook] as $callable){
				$r = call_user_func_array($callable,$param);
				if($return)return $r;
			}
		}
	}
	/**
	* [hashCallable description]
	* @param  [type] $callable [description]
	* @return [type]           [description]
	*/
	public static function hashCallable($callable){
		if(is_array($callable)){
			if(is_object($callable[0])){
				$string = get_class($callable[0]).$callable[1];
			}else{
				$string = implode('',$callable);
			}
		}else{
			$string = $callable;
		}
		return $string;
	}
	/**
	* 加载插件
	*/
	public static function loadPlugin($path,$pre='Koala',$dir='Addons'){
		$path = rtrim($path,'/').'/';
		//遍历插件
		$handle  = opendir($path);
		while($file = readdir($handle)){
			if($file=='.'||$file=='..'){
				continue;
			}
			$newpath=$path.$file;
			if(is_dir($newpath)){
				$class = $pre.'\\'.$dir.'\\'.$file.'\\Action';
			new $class();
			}
		}
	}
}