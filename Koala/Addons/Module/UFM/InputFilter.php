<?php
namespace UFM;
use UFM\FilterFactory;
//对GET,POST进行数据过滤
class InputFilter{
	public function before(){
		$Family = FilterFactory::createExtension('UFM\Rule\inject');
		$Family->append($_GET);
		$Family->append($_POST);
		$Family->append($_REQUEST);
		return array('code'=>1);
	}
}