<?php
defined('IN_Koala') or exit();
class Config extends Initial{
	static $config = array();
	/**
	 * 加载配置
	 * @param  string $file_path 配置文件路路径
	 */
	public  function loadConfig($file_path){
		$cfg = include_once($file_path);
		static::$config = array_merge(static::$config,$cfg);
	}
	/**
	 * 获得配置项
	 * @param  string $key    配置项
	 * @param  string $config 配置数组
	 * @return fixed          配置项值
	 */
	public static function getItem($key,$defv=''){
		list($key,$subkey) = explode(':',$key);
		if(isset($subkey)){
			$subkey = strtolower($subkey);
			switch ($subkey) {
				case 'list':
					return isset(self::$config[$key]['list'])?explode(',',self::$config[$key]['list']):explode(',',$defv);
					break;
				default:
					return isset(self::$config[$key][$subkey])?self::$config[$key][$subkey]:$defv;
					break;
			}
		}else{
			return isset(self::$config[$key])?self::$config[$key]:$defv;
		}
	}
	/**
	 * 获得配置项
	 * @param  array $keys   配置项数组
	 * @param  string $config 配置数组
	 * @return fixed          配置项值数组
	 */
	public static function getItems($keys,$defvs=array()){
		$cfgs = array();
		if(is_string($keys)){
			//字符参数默认以,号作为间隔符
			$keyArr = explode(',', $keys);
		}elseif(is_array($keys)){
			$keyArr = $keys;
		}else{
			return array();
		}
		foreach ($keyArr as $key => $value) {
			$cfgs[$value] = isset(self::$config[$value])?self::$config[$value]:$defvs[$value];
		}
		return $cfgs;
	}
}
?>