<?php
defined('IN_Koala') or exit();
class Core_Cache_Factory{
    protected static $cache_type = 'memcache';
	public static function getInstance($type='memcache',$option=array()){
            Core_Cache_Factory::setCacheType($type);
            $class = 'Core\Cache\Drive\\'.self::$cache_type;
            if(class_exists($class)){
                return new $class($option);
            } 
            else
                return null;
    }
    public static function setCacheType($cacheType='memcache'){
        self::$cache_type=strtolower($cacheType);
        switch(self::$cache_type){
            case 'memcache':
                if(APPENGINE=='SAE'){
                    if (function_exists('memcache_init')) self::$cache_type = 'SAEMemcache' ;
                    else trigger_error('未发现 SAE Memcache 支持!');
                }elseif(APPENGINE=='BAE'){
                    if (class_exists('BaeMemcache')) self::$cache_type = 'BaeMemcache' ;
                    else trigger_error('未发现 BAE Memcache 支持!');
                }else{
                    if (class_exists('Memcache')) self::$cache_type = 'LAEMemcache' ;
                    else trigger_error('未发现 memcache 支持!');
                }
            break;
            case 'eaccelerator':
                if (function_exists('eaccelerator_get'))self::$cache_type = 'eaccelerator';
                else trigger_error('未发现 eaccelerator 支持!');    
            break;
 
            case 'apc':
                if (function_exists('apc_fetch')) self::$cache_type = 'apc' ;
                else trigger_error('未发现 APC 支持!');  
            break;
 
            case 'xcache':
                if (function_exists('xcache_get')) self::$cache_type = 'xcache' ;
                else trigger_error('未发现 Xcache 支持!'); 
            break;
            case 'filecache':
                if (class_exists('fileCache')) self::$cache_type = 'fileCache' ;
                else trigger_error('未发现 fileCache 支持!'); 
            break;
             
            case 'auto'://try to auto select a cache system
                if (function_exists('eaccelerator_get'))    self::$cache_type = 'eaccelerator';                                       
                elseif (function_exists('apc_fetch'))       self::$cache_type = 'apc' ;                                     
                elseif (function_exists('xcache_get'))      self::$cache_type = 'xcache' ;                                        
                elseif (class_exists('Memcache'))           self::$cache_type = 'Memcache' ;
                elseif (class_exists('fileCache'))          self::$cache_type = 'fileCache' ;
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