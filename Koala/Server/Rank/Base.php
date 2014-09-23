<?php
/**
 *
 *对不同云计算平台的Rank服务API支持
 *
 */
namespace Koala\Server\Rank;
class Base implements Face {
	//建立一个排行榜
	public function create($name, $number, $expire = 0) {}
	//设置排行榜某一项的值
	public function set($name, $keys, $value = '') {}
	//获得排行榜相关信息
	public function getInfo($name) {}
	//清除排行榜
	public function clear($name) {}
	//对某项值减并返回排名与值
	public function decrease($name, $key, $value, $rankReturn = false) {}
	//对某项值加并返回排名与值
	public function increase($name, $key, $value, $rankReturn = false) {}
	//删除某项并返回该项的排名与值
	public function delete($name, $key, $rankReturn = false) {}
	//获得所有排行榜
	public function getAllName() {}
	//获得排行榜数据
	public function getList($name, $order = false, $offsetFrom = 0, $offsetTo = PHP_INT_MAX) {}
	//获得某项的值
	public function get($name, $key) {}
	//判断排行榜是否存在
	public function isExist($name) {}
}
?>