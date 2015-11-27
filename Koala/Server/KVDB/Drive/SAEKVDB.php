<?php
namespace Koala\Server\KVDB\Drive;
use Koala\Server\KVDB\Base;
/**
 * 云计算环境下的KVDB驱动
 * 所有文件名使用相对于数据存储区域的路径
 */
final class SAEKVDB extends Base{
	//云服务对象
    var $object = '';
	public function __construct(){
    	$this->object = new \SaeKV();
		// 初始化KVClient对象
		$ret = $this->object->init();
	}
	
	//初始化Sae KV 服务
	final public function init(){
		return $this->object->init();
	}
	//增加key-value对，如果key存在则返回失败
	final public function add($key, $value){
		return $this->object->add($key, $value);
	}
	//删除key-value
	final public function delete($key){
		return $this->object->delete($key);
	}
	//获得错误提示消息
	final public function errmsg(){
		return $this->object->errmsg();
	}
	//获得错误代码
	final public function errno(){
		return $this->object->errno();
	}
	//获得key对应的value
	final public function get($key){
		return $this->object->get($key);
	}
	//获得kv信息
	final public function get_info(){
		return $this->object->get_info();
	}
	//获取选项值
	final public function get_options(){
		return $this->object->get_options();
	}
	//批量获得key-values
	final public function mget($ary){
		return $this->object->mget($ary);
	}
	//前缀范围查找key-values
	final public function pkrget($prefix_key, $count, $start_key){
		return $this->object->pkrget($prefix_key, $count, $start_key);
	}
	//替换key对应的value，如果key不存在则返回失败
	final public function replace($key, $value){
		return $this->object->replace($key, $value);
	}
	//更新key对应的value
	final public function set($key, $value){
		return $this->object->set($key, $value);
	}
	//设置选项值
	final public function set_options($options){
		return $this->object->set_options($options);
	}
}