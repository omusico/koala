<?php
namespace Server\Log;
class Factory extends \Server\Factory{
    public static function getServerName($type){
        $server_name = 'Monolog';
        switch($type){
            case 'Log':
                if(APPENGINE=='SAE'){
                    if (function_exists('SAELog')) $server_name = 'SAELog' ;
                }elseif(APPENGINE=='BAE'){
                    if (class_exists('BaeLog')) $server_name = 'BaeLog' ;
                }else{
                    if (class_exists('Log')) $server_name = 'LAELog' ;
                }
            break;
        }
        return self::getRealName('Log',$server_name);
    }
}