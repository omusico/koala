<?php
namespace UUM\Extension;
use UUM\Interfaces\Identity;

/**
*匿名认证具体实现
*/
class  AnyoneIdentity implements Identity{
	public function append($user){
		echo '进行匿名认证';
	}
	public function getStatus(){}
}