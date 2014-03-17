<?php
defined('IN_Koala') or exit();
/**
 * SAE环境下的Channel驱动
 */
final class Drive_SAEChannel extends Base_Channel{
	//云服务对象
    var $object = '';
	public function __construct(){
		$this->object = new SaeChannel();
	}
	public function createChannel(channel,$duration=3600){

	}
    public function sendMessage($channel,$content){
    	
    }

}
?>