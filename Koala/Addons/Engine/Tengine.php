<?php
class Engine_Tengine{
	static $ins='';
	public static function factory($option){
		//self::$ins = new Tengine();
		//return $ins;
		return new static();
	}
	public function __call($method,$args){
		echo 'Koala框架成功运行!<br>欢迎使用。';
	}
}