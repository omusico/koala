<?php
defined('IN_Koala') or exit();
class Factory_Cache{
	protected static $instance = null;
    protected $cache_type = 'auto';
	public static function getInstance($type='auto',$group=''){
        if (!isset(self::$instance)){
            self::$instance = new Factory_Cache();
            self::$instance->setCacheType($type);
            if(stripos(self::$instance->cache_type,APPENGINE)===false){
                $class = 'Drive_'.self::$instance->cache_type;
            }else{
                $class = 'Drive_'.self::$instance->cache_type;
                if(!class_exists($class)){
                    $class = self::$instance->cache_type;
                }
            }
            if(class_exists($class)){
                self::$instance = new $class($group);
            } 
            else
                return null;
        } 
        return self::$instance;
    }
    public function setCacheType($cacheType='auto'){
        $this->cache_type=strtolower($cacheType);
        switch($this->cache_type){
            case 'memcache':
                if(APPENGINE=='SAE'){
                    if (function_exists('memcache_init')) $this->cache_type = 'SAEMemcache' ;
                    else trigger_error('未发现 SAE Memcache 支持!');
                }elseif(APPENGINE=='BAE'){
                    if (class_exists('BaeMemcache')) $this->cache_type = 'BaeMemcache' ;
                    else trigger_error('未发现 BAE Memcache 支持!');
                }else{
                    if (class_exists('Memcache')) $this->cache_type = 'Memcache' ;
                    else trigger_error('未发现 memcache 支持!');
                }
            break;
            case 'eaccelerator':
                if (function_exists('eaccelerator_get'))$this->cache_type = 'eaccelerator';
                else trigger_error('未发现 eaccelerator 支持!');    
            break;
 
            case 'apc':
                if (function_exists('apc_fetch')) $this->cache_type = 'apc' ;
                else trigger_error('未发现 APC 支持!');  
            break;
 
            case 'xcache':
                if (function_exists('xcache_get')) $this->cache_type = 'xcache' ;
                else trigger_error('未发现 Xcache 支持!'); 
            break;
            case 'filecache':
                if (class_exists('fileCache')) $this->cache_type = 'fileCache' ;
                else trigger_error('未发现 fileCache 支持!'); 
            break;
             
            case 'auto'://try to auto select a cache system
                if (function_exists('eaccelerator_get'))    $this->cache_type = 'eaccelerator';                                       
                elseif (function_exists('apc_fetch'))       $this->cache_type = 'apc' ;                                     
                elseif (function_exists('xcache_get'))      $this->cache_type = 'xcache' ;                                        
                elseif (class_exists('Memcache'))           $this->cache_type = 'Memcache' ;
                elseif (class_exists('fileCache'))          $this->cache_type = 'fileCache' ;
                else trigger_error('没有发现任何可用的缓存支持');
            break;
            default://not any cache selected or wrong one selected
                if (isset($cacheType)) $msg='未识别的缓存类型<b>'.$cacheType.'</b>';
                else $msg='没有提供缓存类型设置';
                trigger_error($msg);     
            break;
        }
    }
}
?>