<?php
namespace UUM\Extension;
use UUM\Interfaces\Identity;
/**
*认证扩展家族
*/
class IdentityFamily implements Identity{
	//扩展数组 
	private $_extensionArray = array();
	//状态数组
	private $_status = array();
	// 添加扩展 
	public function addExtension(Identity $extension) { 
		$this->_extensionArray[]= $extension; 
	}
	public function append($user) { 
		foreach ($this->_extensionArray as $extension) { 
			$extension->append($user);
			$this->_status[get_class($extension)] = $extension->getStatus();
		} 
	}
	public function getStatus(){
		return $this->_status;
	}
}