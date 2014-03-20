<?php
namespace UUM\Extension;
use UUM\Interfaces\Identity;

/**
*IP认证具体实现
*/
class  IPIdentity implements Identity{
	public function append($user){
		//echo '进行IP认证';
	}
	public function getStatus(){}
}