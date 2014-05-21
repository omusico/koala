<?php
namespace Koala\Server\Rank\Drive;
use Koala\Server\Rank\Base;
/**
 * BAE环境下的Rank驱动
 */
final class BAERank extends Base{
	public function __construct(){}
	//建立一个排行榜
	public function create($name, $number, $expire = 0){
		$object = \BaeRankManager::getInstance();
		return $object->create($name, $number);
	}
	//设置排行榜某一项的值
	public function set($name,$keys,$value=''){
		$r= new \BaeRank($name);
		if(is_string($keys)){
			$keys = array($keys=>$value);
		}
		return $r->set($keys);
	}
	//获得排行榜相关信息
	public function getInfo($name){
		$r= new \BaeRank($name);
		return $r->query();
	}
	//清除排行榜
	public function clear($name){
		$r= new \BaeRank($name);
		return $r->clear();
	}
	//对某项值减并返回排名与值
	public function decrease($name,$key,$value,$rankReturn=false){
		$r= new \BaeRank($name);
		$r->decrease($key,$value);
		return  $r->get($key);
	}
	//对某项值加并返回排名与值
	public function increase($name,$key,$value,$rankReturn=false){
		$r= new \BaeRank($name);
		$r->increase($key,$value);
		return  $r->get($key);
	}
	//删除某项并返回该项的排名与值
	public function delete($name,$key,$rankReturn=false){
		$r= new \BaeRank($name);
		$ret = $r->get($key);
		$r->remove($key);
		return $ret;
	}
	//获得所有排行榜
	public function getAllName(){
		$object = \BaeRankManager::getInstance();
		return $object->getList();
	}
	//获得排行榜数据
	public function getList($name,$order = false, $offsetFrom = 0,$offsetTo = PHP_INT_MAX){
		$r= new \BaeRank($name);
		return $r->getList($offsetFrom,$offsetTo);
	}
	//获得某项的排名与值
	public function get($name,$key){
		$r= new \BaeRank($name);
		return $r->get($key);
	}
  	//判断排行榜是否存在
	public function isExist($name){
		$object = \BaeRankManager::getInstance();
		return $object->isExist($name);
	}
}
?>