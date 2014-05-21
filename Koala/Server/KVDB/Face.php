<?php
namespace Koala\Server\KVDB;
interface Face{
    //初始化
    function __construct();
    //增加key-value对，如果key存在则返回失败
	public function add($key, $value);
	//删除key-value
	public function delete($key);
	//获得错误提示消息
	public function errmsg();
	//获得错误代码
	public function errno();
	//获得key对应的value
	public function get($key);
	//获得kv信息
	public function get_info();
	//获取选项值
	public function get_options();
	//批量获得key-values
	public function mget($ary);
	//前缀范围查找key-values
	public function pkrget($prefix_key, $count, $start_key);
	//替换key对应的value，如果key不存在则返回失败
	public function replace($key, $value);
	//更新key对应的value
	public function set($key, $value);
	//设置选项值
	public function set_options($options);
}