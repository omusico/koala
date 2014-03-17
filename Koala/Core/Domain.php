<?php
defined('IN_Koala') or exit();
//域名部署
class Domain extends Config{
	//调度配置
	public static $cfg = array();
	//调度数据
	public static $data = array();
	public static function Dispatch($domain=''){
		//读取调度参数
		self::$cfg = parent::getItem(__CLASS__);
		if(array_key_exists($domain['host'].$domain['name'],self::$cfg['Router'])){
			//请求参数
			$_SERVER['REQUEST_URI'] = self::$cfg['Router'][$domain['host'].$domain['name'].'/manage'];
		}
	}
}
?>