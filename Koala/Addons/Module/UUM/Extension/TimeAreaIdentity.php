<?php
namespace UUM\Extension;
use UUM\Interfaces\Identity;

/**
*时间段认证具体实现
*/
class  TimeAreaIdentity implements Identity{
	public function append($user){
		echo '进行时间段认证';
	}
	public function getStatus(){}
}