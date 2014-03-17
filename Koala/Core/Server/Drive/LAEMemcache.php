<?php
defined('IN_Koala') or exit();
/**
 *按组缓存
 * 
 */
class Drive_LAEMemcache extends Base_Cache{
    protected $mmc = null; 
    public $group = null; 
    protected $version = 1; 
    /**
     *配置信息，servers支持配置多个服务器,servers=>array(array('host'=>'host1', 'port'=>11211),array('host'=>'host2', 'port'=>11211))
     */
    public $cfg = array(
            'expire'=>3600,/* 缓存时间 */
            'compress'=>1,/* 是否压缩存储 */
            'servers'=>array(
                    'host'=>'127.0.0.1',
                    'port'=>11211
            )
    );
    /**
     * new Cache('abc'); // 要有域 
     */
    function __construct($group='',$config=array()){
        if(!class_exists('memcache')){
            $this->mmc = false;
            trigger_error('Memcache未启用!');
            return; 
        }
        if($config){
            $this->cfg = $config + $this->cfg;//合并配置
        }
        $this->mmc = new Memcache;
        //支持多个memcache服务器
        if(isset($this->cfg['servers']['host'])) {
            $this->mmc->addServer($this->cfg['servers']['host'], $this->cfg['servers']['port']);
        }else{
            foreach($this->cfg['servers'] as $v){
                    $this->mmc->addServer($v['host'], $v['port']);
            }
        }
        if($group==''){
             //trigger_error('请设置group值!');
            return; 
        }else{
            $this->group = self::getRealGroup($group);
            $version=$this->mmc->get('version_'.$group);//无数据第一次运行时的警告怎样抑制?
            if(!empty($version)){
                $this->version = $version;
            }else{
                $this->mmc->set('version_'.$this->group, $this->version);
            }
        }
        
    } 
    function set($key, $var,$compress='',$expire=3600){ 
        if(!$this->mmc)return; 
        if(!$expire){
            $expire = $this->cfg['expire'];
        }
        if($compress!=''){
            $this->cfg['compress'] = $compress;
        }
        return $this->mmc->set($this->group.'_'.$this->version.'_'.$key, $var,$this->cfg['compress'] ? MEMCACHE_COMPRESSED : 0, $expire); 
    } 
    function get($key){
        if(!$this->mmc)return;
        return $this->mmc->get($this->group.'_'.$this->version.'_'.$key); 
    } 
    function incr($key, $value=1){ 
        if(!$this->mmc)return; 
        return $this->mmc->increment($this->group.'_'.$this->version.'_'.$key, $value); 
    } 
    function decr($key, $value=1){ 
        if(!$this->mmc)return; 
        return $this->mmc->decrement($this->group.'_'.$this->version.'_'.$key, $value); 
    } 
    function delete($key){ 
        if(!$this->mmc)return; 
        return $this->mmc->delete($this->group.'_'.$this->version.'_'.$key); 
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
        $this->mmc->set('version_'.$this->group, $this->version); 
    }
    function flushAll(){ 
        if(!$this->mmc)return; 
         return $this->mmc->flush();
    }
} 
?>