<?php
namespace Server\Log;
class Factory extends \Server\Factory{
    public static function getServerName($type){
        $server_name = 'Monolog';
        switch($type){
            case 'Log':
                if(APPENGINE=='SAE'){
                    if (function_exists('SAELog')) $server_name = 'SAELog' ;
                    else trigger_error('未发现 SAE Memcache 支持!');
                }elseif(APPENGINE=='BAE'){
                    if (class_exists('BaeLog')) $server_name = 'BaeLog' ;
                    else trigger_error('未发现 BAE Memcache 支持!');
                }else{
                    if (class_exists('Log')) $server_name = 'LAELog' ;
                    else trigger_error('未发现 Log 支持!');
                }
            break;
        }
        return self::getRealName('Log',$server_name);
    }
}