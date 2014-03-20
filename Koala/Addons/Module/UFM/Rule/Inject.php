<?php
namespace UFM\Rule;
use UFM\Interfaces\Filter;

/**
*具体实现
*/
class  Inject implements Filter{
	public function append(&$param=array()){
		if (!get_magic_quotes_gpc()){
			addslashes_array($param);
		}
	}
	public function getStatus(){}
}