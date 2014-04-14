<?php
namespace UFM;
use UFM\Rule\FilterFamily;
/**
* 过滤规则扩展工厂
*/
class FilterFactory{
	public static function createExtension($list) { 
		$obj = new FilterFamily();
		$lists = explode(',', $list);
		// 添加扩展
		foreach ($lists as $key => $class) {
			$obj->addExtension(new $class());
		}
		return $obj; 
	} 
}