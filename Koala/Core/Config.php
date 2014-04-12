<?php
class Config extends Initial{
	static $config = array();
	/**
	 * 加载配置
	 * @param  string $file_path 配置文件路路径
	 */
	public function loadConfig($file_path){
		$cfg = require($file_path);
		self::$config = array_merge(self::$config,$cfg);
	}
	/**
	 * 获得配置项
	 * @param  string $key    配置项
	 * @param  string $config 配置数组
	 * @param  bool $runtime  运行时设置 true/false
	 * @return fixed          配置项值
	 */
	public static function getItem($key,$defv='',$runtime=false){
		if($runtime && $defv!=''){
			return $defv;
		}
		$arr = explode(':',$key);
		if(count($arr)>1){
			list($key,$subkey) = $arr;
		}else{
			$key = $arr[0];
		}
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
	 * @param  bool $runtime  运行时设置 true/false
	 * @return fixed          配置项值数组
	 */
	public static function getItems($keys,$defvs=array(),$runtime=false){
		if($runtime && !empty($defvs)){
			return $defvs;
		}
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
	/**
	 * 获取配置文件路径
	 */
	public static function getPath($file){
		if(APPENGINE!=='LAE'){
			return STOR_PATH.$file;
		}else{
			return APP_PATH.$file;
		}
	}
}
?>