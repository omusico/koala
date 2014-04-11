<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   Lunnlew <Lunnlew@gmail.com>
 */
/**
 * 缓存工厂实现
 * 
 * @package  Koala\Server\Cache
 * @author    Lunnlew <Lunnlew@gmail.com>
 * @final
 */
namespace Server\Cache;
final class Factory extends \Server\Factory{
    /**
     * 获取正式服务名
     * @param  string $name 服务名
     * @static
     * @return string       正式服务名
     */
    public static function getServerName($name){
        $server_name = 'LAEMemcache';
        switch ($name) {
            case 'memcache':
                if(APPENGINE=='SAE'){
                    if (function_exists('memcache_init')) $server_name = 'SAEMemcache' ;
                }elseif(APPENGINE=='BAE'){
                    if (class_exists('BaeMemcache')) $server_name = 'BaeMemcache' ;
                }else{
                    if (class_exists('Memcache')) $server_name = 'LAEMemcache' ;
                }
            break;
            case 'eaccelerator':
                if (function_exists('eaccelerator_get'))$server_name = 'eaccelerator';
            break;
 
            case 'apc':
                if (function_exists('apc_fetch')) $server_name = 'apc' ;
            break;
 
            case 'xcache':
                if (function_exists('xcache_get')) $server_name = 'xcache' ;
            break;
            case 'filecache':
                if (class_exists('fileCache')) $server_name = 'fileCache' ;
            break;
             
            case 'auto'://try to auto select a cache system
                if (function_exists('eaccelerator_get'))    $server_name = 'eaccelerator';                                       
                elseif (function_exists('apc_fetch'))       $server_name = 'apc' ;                                     
                elseif (function_exists('xcache_get'))      $server_name = 'xcache' ;                                        
                elseif (class_exists('Memcache'))           $server_name = 'Memcache' ;
                elseif (class_exists('fileCache'))          $server_name = 'fileCache' ;
            break;
        }
        return self::getRealName('Cache',$server_name);
    }
}