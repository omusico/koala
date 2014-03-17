<?php
namespace UUM\Extension;
use UUM\Interfaces\Identity;

/**
*访问次数认证具体实现
*/
class  AccessNumIdentity implements Identity{
	public function append($user){
		echo '进行访问次数认证';
	}
	public function getStatus(){}
}