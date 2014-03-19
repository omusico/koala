<?php
class Engine_Tengine{
	public function __construct($option=array()){

	}
	/**
	 * 注册变量
	 * @param  string $key
	 * @param  mixed $value
	 */
	public function assign($key,$value){
		echo 'key:'.$key.'=>value:'.$value.'<br>';
	}
	/**
	 * 模板输出
	 * @param  string $tpl 模板名
	 */
	public function show($tpl=''){
		echo 'tpl:'.$tpl.'<br>';
	}
	/**
	 * 模板输出
	 * @param  string $tpl 模板名
	 */
	public function display($tpl=''){
		echo 'tpl:'.$tpl.'<br>';
	}
	/**
	 * 返回模板
	 * @param  string $tpl 模板名
	 */
	public function fetch($tpl=''){
		echo 'tpl:'.$tpl.'<br>';
	}
}