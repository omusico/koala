<?php
namespace Core\Counter\Drive;
use Core_Counter_Base;
/**
 * SAE环境下的Channel驱动
 */
final class SAEChannel extends Core_Counter_Base{
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