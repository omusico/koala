<?php
defined('IN_Koala') or exit();
class Drive_LAEeaccelerator extends Base_Cache{
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
        if(!function_exists('eaccelerator_get')){
            trigger_error('eaccelerator未启用!');
            return; 
        }
        if($config){
            $this->cfg = $config + $this->cfg;//合并配置
        }
        $this->group = self::getRealGroup($group);
        $version= @unserialize(eaccelerator_get('version_'.$this->group));
        if(!empty($version)){
            $this->version = $version;
        }else{
            eaccelerator_put('version_'.$this->group, serialize($this->version));
        }
    }
    function set($key, $var, $expire=3600){
        if(!$expire){
            $expire = $this->cfg['expire'];
        }
    	return eaccelerator_put($this->group.'_'.$this->version.'_'.$key, serialize($var), $expire);
    }
    function get($key){
    	 return @unserialize(eaccelerator_get($this->group.'_'.$this->version.'_'.$key));
    } 
    function incr($key, $value=1){} 
    function decr($key, $value=1){} 
    function delete($key){
    	return eaccelerator_rm($this->group.'_'.$this->version.'_'.$key);
    }
    function compress($threshold=2000,$min_savings=0.2){return;}
    function flush(){
    	if( FALSE === $this->version){ 
            $this->version = 1; 
        }else{
            ++$this->version; 
        }
        eaccelerator_put('version_'.$this->group, serialize($this->version));
    }
    function flushAll(){
    	@eaccelerator_clean();
        @eaccelerator_clear();
        return;
    }
}
?>