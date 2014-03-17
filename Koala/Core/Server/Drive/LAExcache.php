<?php
defined('IN_Koala') or exit();
class Drive_LAExcache extends Base_Cache{
	public $group = null; 
    protected $version = 1; 
    /**
     *配置信息，servers支持配置多个服务器,servers=>array(array('host'=>'host1', 'port'=>11211),array('host'=>'host2', 'port'=>11211))
     */
    public $cfg = array(
            'expire'=>3600,/* 缓存时间 */
            'compress'=>1,/* 是否压缩存储 */
    );
    /**
     * new Cache('abc'); // 要有域 
     */
    function __construct($group,$config=array()){
        if(!function_exists('xcache_get')){
            trigger_error('xcache未启用!');
            return; 
        }
        if($config){
            $this->cfg = $config + $this->cfg;//合并配置
        }
        $this->group = self::getRealGroup($group);
        $version=@unserialize(xcache_get('version_'.$this->group));
        if(!empty($version)){
            $this->version = $version;
        }else{
            xcache_set('version_'.$this->group, serialize($this->version));
        }
    }
    function set($key, $var, $expire=3600){
    	return xcache_set($this->group.'_'.$this->version.'_'.$key, serialize($var), $expire);
    } 
    function get($key){
    	return @unserialize(xcache_set($this->group.'_'.$this->version.'_'.$key));
    } 
    function incr($key, $value=1){} 
    function decr($key, $value=1){} 
    function delete($key){
    	return xcache_unset($this->group.'_'.$this->version.'_'.$key);
    }
    function compress($threshold=2000,$min_savings=0.2){}
    function flush(){
    	if( FALSE === $this->version){ 
            $this->version = 1; 
        }else{
            ++$this->version; 
        }
        xcache_set('version_'.$this->group, serialize($this->version));
    }
    function flushAll(){
    	xcache_clear_cache(XC_TYPE_VAR, 0);
        return;
    }
}
?>