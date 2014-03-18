<?php
namespace Server\Cache\Drive;
use Server_Cache_Base;

class LAEapc extends Server_Cache_Base{
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
        $version=eaccelerator_get('version_'.$this->group());
        if(!empty($version)){
            $this->version = $version;
        }else{
            apc_store('version_'.$this->group(), $this->version);
        }
    }
    function set($key, $var, $expire=3600){
        if(!$expire){
            $expire = $this->option['expire'];
        }
         return apc_store($this->key($key), $var, $expire);
    } 
    function get($key){
        return apc_fetch($this->key($key));
    } 
    function incr($key, $value=1){} 
    function decr($key, $value=1){} 
    function delete($key){
        return apc_delete($this->key($key));
    }
    function compress($threshold=2000,$min_savings=0.2){}
    function flush(){
        if( FALSE === $this->version){ 
            $this->version = 1; 
        }else{
            ++$this->version; 
        }
        apc_store('version_'.$this->group(), $this->version);
    }
    function flushAll(){
        apc_clear_cache('user');
        return 0;
    }
}
?>