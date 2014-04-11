<?php
namespace Server\Cache\Drive;
use Server\Cache\Base;
use Memcache;
class LAEMemcache extends Base{
    var $option=array(
        'group'=>'[APP_NAME][APP_VERSION]',
        'expire'=>3600,
        'compress'=>1,
        'servers'=>array(
          'host'=>'127.0.0.1',
          'port'=>11211
          )
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
        $this->mmc = new Memcache;
        //支持多个memcache服务器
        if(isset($this->option['servers']['host'])) {
            $this->mmc->addServer($this->option['servers']['host'], $this->option['servers']['port']);
        }else{
            foreach($this->option['servers'] as $v){
                    $this->mmc->addServer($v['host'], $v['port']);
            }
        }
        $version=$this->mmc->get('version_'.$this->group());//无数据第一次运行时的警告怎样抑制?
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