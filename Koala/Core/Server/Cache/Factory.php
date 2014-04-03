<?php
namespace Server\Cache;
class Factory extends \Server\Factory{
    public static function getServerName($type){
        $server_name = 'LAEMemcache';
        switch ($type) {
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
?>