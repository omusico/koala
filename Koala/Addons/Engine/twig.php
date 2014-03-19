<?php
class Engine_twig{
	//实例
	static $ins='';
	//默认选项
	static $option=array();
	//变量表
	static $vars = array();
	public static function factory($option){
		return new static();
	}
	public function __call($method,$args){
		echo '尚未统一化方法支持,你可以直接使用原生代码。<br>';
	}
}