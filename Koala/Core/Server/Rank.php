<?php
defined('IN_Koala') or exit();
/**
 * 
 *对不同云计算平台的Rank服务API支持
 *
 */
class Rank{
	static $object = null;
	public static function __callStatic($method,$args){
		if(self::$object==''){
			self::$object = Server::getInstance('Rank');
		}
		if(method_exists(self::$object, $method)){
			$res = call_user_func_array(array(self::$object,$method),$args);
			return $res;
		}
		return null;
	}
	//建立一个排行榜
	public static function create($name, $number, $expire = 0){
		$m = explode('::',__METHOD__);
    	$p = func_get_args();
    	return self::__callStatic($m[1],$p);
	}
	//设置排行榜某一项的值
	public static function set($name,$key,$value){
		$m = explode('::',__METHOD__);
    	$p = func_get_args();
    	return self::__callStatic($m[1],$p);
	}
	//获得排行榜相关信息
	public static function getInfo($name){
		$m = explode('::',__METHOD__);
    	$p = func_get_args();
    	return self::__callStatic($m[1],$p);
	}
	//清除排行榜
	public static function clear($name){
		$m = explode('::',__METHOD__);
    	$p = func_get_args();
    	return self::__callStatic($m[1],$p);
	}
	//对某项值减并返回排名
	public static function decrease($name,$key,$value,$rankReturn=false){
		$m = explode('::',__METHOD__);
    	$p = func_get_args();
    	return self::__callStatic($m[1],$p);
	}
	//对某项值加并返回排名
	public static function increase($name,$key,$value,$rankReturn=false){
		$m = explode('::',__METHOD__);
    	$p = func_get_args();
    	return self::__callStatic($m[1],$p);
	}
	//删除某项并返回该项的排名
	public static function delete($name,$key,$rankReturn=false){
		$m = explode('::',__METHOD__);
    	$p = func_get_args();
    	return self::__callStatic($m[1],$p);
	}
	//获得所有排行榜
	public static function getAllName(){
		$m = explode('::',__METHOD__);
    	$p = func_get_args();
    	return self::__callStatic($m[1],$p);
	}
	//获得排行榜数据
	public static function getList($name,$order = false, $offsetFrom = 0,$offsetTo = PHP_INT_MAX){
		$m = explode('::',__METHOD__);
    	$p = func_get_args();
    	return self::__callStatic($m[1],$p);
	}
	//获得某项的值
	public static function get($name,$key){
		$m = explode('::',__METHOD__);
    	$p = func_get_args();
    	return self::__callStatic($m[1],$p);
	}
}
?>