<?php
namespace UUM;
use UUM\Extension\IdentityFamily;
use UUM\Extension\PassIdentity;
/**
*认证扩展工厂
*/
class IdentityFactory{
	public static function createExtension($list) { 
		$obj = new IdentityFamily();
		$lists = explode(',', $list);
		// 添加扩展
		foreach ($lists as $key => $class) {
			$obj->addExtension(new $class());
		}
		return $obj; 
	} 
}