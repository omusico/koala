<?php
defined('IN_Koala') or exit();
class Drive_LAEapc extends Base_Cache{
    public $group = null; 
    protected $version = 1;
    public $cfg = array(
            'expire'=>3600,/* 缓存时间 */
            'compress'=>1,/* 是否压缩存储 */
    );
    /**
     * new Cache('abc'); // 要有域 
     */
    function __construct($group,$config=array()){
        if(!function_exists('apc_fetch')){
            trigger_error('apc未启用!');
            return; 
        }
        if($config){
            $this->cfg = $config + $this->cfg;//合并配置
        }
        $this->group = self::getRealGroup($group);
        $version=eaccelerator_get('version_'.$this->group);
        if(!empty($version)){
            $this->version = $version;
        }else{
            apc_store('version_'.$this->group, $this->version);
        }
    }
    function set($key, $var, $expire=3600){
         return apc_store($this->group.'_'.$this->version.'_'.$key, $var, $expire);
    } 
    function get($key){
        return apc_fetch($this->group.'_'.$this->version.'_'.$key);
    } 
    function incr($key, $value=1){} 
    function decr($key, $value=1){} 
    function delete($key){
        return apc_delete($this->group.'_'.$this->version.'_'.$key);
    }
    function compress($threshold=2000,$min_savings=0.2){}
    function flush(){
        if( FALSE === $this->version){ 
            $this->version = 1; 
        }else{
            ++$this->version; 
        }
        apc_store('version_'.$this->group, $this->version);
    }
    function flushAll(){
        apc_clear_cache('user');
        return 0;
    }
}
?>