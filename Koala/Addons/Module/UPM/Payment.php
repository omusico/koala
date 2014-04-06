<?php
/**
 * UPM适配器实例化类
 */
class UPM_Payment{
	public function __construct(){
	}
	public function setAdapter($name,$config){
		$class = self::getAdapterClass($name);
		$instance = new $class();
		$instance->setConfig($config);
		return $instance;
	}
	//获得适配器类
	private function getAdapterClass($name){
		if(empty($name)){
			return null;
		}
		return 'UPM_Adapter_'.$name;
	}
}
?>