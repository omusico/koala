<?php
defined('IN_Koala') or exit();
/**
 * 缓存基类
 */
class Core_Cache_Base{
    static $adapter = null;
    static $options = array();
    static $prefix = APR;
    /**
     * 组装缓存前缀和组
     * @param  string $group 缓存组
     * @return string        真实缓存组
     */
    final public function getRealGroup($group){
    	echo static::$prefix.$group;exit;
    	return static::$prefix.$group;
    }
    abstract public function initialize($url, $options=array());
    abstract public function read($key);
    abstract public function write($key,$value,$expire);
    abstract public function flush();
}
?>