<?php
namespace Koala\Server\Counter\Drive;
use Koala\Server\Counter\Base;
/**
 * SAE的Counter驱动
 * 
 */
final class SAECounter extends Base{
    //云服务对象
    var $object = '';
    public function __construct(){
        $this->object = new \SaeCounter();
    }
    // 增加一个计数器name。
    final public function create($name, $value = 0,$expires=-1){
        return  $this->object->create($name, $value);
    } 
    // 删除名称为name的计数器。
    final public function remove($name){
        return  $this->object->remove($name);
    }
    // 获取计数器name的value。
    final public function get($name){
        return  $this->object->get($name);
    } 
    // 重新设置计数器name的值为value。
    final public function set($name, $value){
        return  $this->object->set($name, $value);
    }
    // 获取多个计数器name的value。
    final public function mget($list){
        return  $this->object->mget($list);
    } 
    // 重新设置多个计数器name的值为value。
    final public function mset($keys){
        $num=0;
        foreach($keys as $name=>$value){
            $this->object->set($name, $value);
            ++$num;
        }
        return $num;
    }
    // 对计数器name做加法操作，默认加1。
    final public function decrease($name, $vaule = 1 ){
        return  $this->object->incr($name, $vaule);
    } 
    // 对计数器name做减法操作，默认减1。
    final public function increase($name, $vaule = 1 ){
        return  $this->object->decr($name, $vaule);
    }
    // 获取该应用的所有计数器。
    final public function getAllList(){
      return $this->object->list();
    }
    // 判断计数器name是否存在。
    final public function isExist($name){
        return  $this->object->exists($name);
    }
    // 成功返回该应用的计数器总量，失败返回false。
    final public function getNums(){
        return  $this->object->length();
    }
    //----------------
    //返回所有计数器值
    final public function getAll(){
        return  $this->object->getall();
    }
}
?>