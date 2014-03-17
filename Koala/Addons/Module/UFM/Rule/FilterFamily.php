<?php
namespace UFM\Rule;
use UFM\Interfaces\Filter;
/**
*	扩展家族
*/
class FilterFamily implements Filter{
	//扩展数组 
	private $_extensionArray = array();
	//状态数组
	private $_status = array();
	// 添加扩展 
	public function addExtension(Filter $extension) { 
		$this->_extensionArray[]= $extension; 
	}
	public function append(&$param=array()) { 
		foreach ($this->_extensionArray as $extension) { 
			$extension->append($param);
			$this->_status[get_class($extension)] = $extension->getStatus();
		} 
	}
	public function getStatus(){
		return $this->_status;
	}
}
