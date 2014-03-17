<?php
defined('IN_Koala') or exit();
//排行榜抽象接口类
abstract class Base_Rank{
	//建立一个排行榜
	abstract public function create($name, $number, $expire = 0);
	//设置排行榜某一项的值
	abstract public function set($name,$keys,$value='');
	//获得排行榜相关信息
	abstract public function getInfo($name);
	//清除排行榜
	abstract public function clear($name);
	//对某项值减并返回排名与值
	abstract public function decrease($name,$key,$value,$rankReturn=false);
	//对某项值加并返回排名与值
	abstract public function increase($name,$key,$value,$rankReturn=false);
	//删除某项并返回该项的排名与值
	abstract public function delete($name,$key,$rankReturn=false);
	//获得所有排行榜
	abstract public function getAllName();
	//获得排行榜数据
	abstract public function getList($name,$order = false, $offsetFrom = 0,$offsetTo = PHP_INT_MAX);
	//获得某项的值
	abstract public function get($name,$key);
  	//判断排行榜是否存在
	abstract public function isExist($name);
}