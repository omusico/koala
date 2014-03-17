<?php
class Core_Cache_Base implements Core_Cache_Face{
    public function __construct(){}
    //获得指定key的值
    public function get($key){
        return $this->get($key);
    }
    //设置key的值为value,并设置过期时间
    public function set($key,$value,$expire=3600){
        return $this->set($key,$value,$expire);
    }
    //删除指定key
    public function delete($key){
        return $this->delete($key);
    }
    //缓存清空
    public function flush(){
        return $this->flush($key);
    }


    function key($key){
        return $this->option['group'].'_'.$this->version.'_'.$key;
    }
    function group(){
        return $this->option['group'];
    }
}
?>