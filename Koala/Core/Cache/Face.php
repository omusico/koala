<?php
interface Core_Cache_Face{
    //初始化
    function __construct();
    //获得指定key的值
    public function get($key);
    //设置key的值为value,并设置过期时间
    public function set($key,$value,$expire=3600);
    //删除指定key
    public function delete($key);
    //缓存清空
    public function flush();
}
?>