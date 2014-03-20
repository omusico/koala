<?php
namespace UUM\Extension;
use UUM\Interfaces\Identity;

/**
*密码认证具体实现
*/
class  PassIdentity implements Identity{
	static $_status;
	public function append($user){
		\UUM_Logic_User::setTable($user->type);
		self::$_status = \UUM_Logic_User::Login($user->username,$user->password);
	}
	public function getStatus(){
		return self::$_status;
	}
}