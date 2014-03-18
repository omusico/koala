<?php
namespace Server\Cache\Drive;
use Server_Cache_Base;
class SAEMemcache extends Server_Cache_Base{
    protected $version = 1; 
    /**
     *配置信息，servers支持配置多个服务器,servers=>array(array('host'=>'host1', 'port'=>11211),array('host'=>'host2', 'port'=>11211))
     */
    public $option = array();
    function __construct($option=array()){
        if(!empty($option)){
            $this->option = $option + $this->option;//合并配置
        }
        preg_match_all('/[\w]+/',$this->option['group'], $res);
        foreach ($res[0] as $key => $value) {
            $group .= constant($value);
        }
        $this->option['group'] = $group;

       	$this->mmc = memcache_init();
        $version=$this->mmc->get('version_'.$group());//无数据第一次运行时的警告怎样抑制?
        if(!empty($version)){
            $this->version = $version;
        }else{
            $this->mmc->set('version_'.$this->group(), $this->version);
        }
        
    } 
    function set($key, $var,$compress='',$expire=3600){ 
        if(!$this->mmc)return; 
        if(!$expire){
            $expire = $this->option['expire'];
        }
        if($compress!=''){
            $this->option['compress'] = $compress;
        }
        return $this->mmc->set($this->key($key), $var,$this->option['compress'] ? MEMCACHE_COMPRESSED : 0, $expire); 
    } 
    function get($key){
        if(!$this->mmc)return;
        return $this->mmc->get($this->key($key)); 
    } 
    function incr($key, $value=1){ 
        if(!$this->mmc)return; 
        return $this->mmc->increment($this->key($key), $value); 
    } 
    function decr($key, $value=1){ 
        if(!$this->mmc)return; 
        return $this->mmc->decrement($this->key($key), $value); 
    } 
    function delete($key){ 
        if(!$this->mmc)return; 
        return $this->mmc->delete($this->key($key)); 
    }
    function compress($threshold=2000,$min_savings=0.2){
        //大于2k以0.2压缩比压缩.
        if(!$this->mmc)return; 
        $this->mmc->setCompressThreshold($threshold,$min_savings); 
    }
    function flush(){ 
        if(!$this->mmc)return;
        if( FALSE === $this->version){ 
            $this->version = 1; 
        }else{
            ++$this->version; 
        }
        $this->mmc->set('version_'.$this->group(), $this->version); 
    }
    function flushAll(){ 
        if(!$this->mmc)return; 
         return $this->mmc->flush();
    }
} 
?>