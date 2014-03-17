<?php
defined('IN_Koala') or exit();
namespace Core\Cache\Drive;
use Core_Cache_Base;
class LAExcache extends Core_Cache_Base{
    var $option=array(
        'group'=>'[APP_NAME][APP_VERSION]',
        'expire'=>3600,
        'compress'=>1
    );
    protected $version = 1; 
    function __construct($option=array()){
        if(!empty($option)){
            $this->option = $option + $this->option;//合并配置
        }
        preg_match_all('/[\w]+/',$this->option['group'], $res);
        foreach ($res[0] as $key => $value) {
            $group .= constant($value);
        }
        $this->option['group'] = $group;
        $version=@unserialize(xcache_get('version_'.$this->group()));
        if(!empty($version)){
            $this->version = $version;
        }else{
            xcache_set('version_'.$this->group(), serialize($this->version));
        }
    }
    function set($key, $var, $expire=3600){
        if(!$expire){
            $expire = $this->option['expire'];
        }
    	return xcache_set($this->key($key), serialize($var), $expire);
    } 
    function get($key){
    	return @unserialize(xcache_set($this->key($key)));
    } 
    function incr($key, $value=1){} 
    function decr($key, $value=1){} 
    function delete($key){
    	return xcache_unset($this->key($key));
    }
    function compress($threshold=2000,$min_savings=0.2){}
    function flush(){
    	if( FALSE === $this->version){ 
            $this->version = 1; 
        }else{
            ++$this->version; 
        }
        xcache_set('version_'.$this->group(), serialize($this->version));
    }
    function flushAll(){
    	xcache_clear_cache(XC_TYPE_VAR, 0);
        return;
    }
}
?>