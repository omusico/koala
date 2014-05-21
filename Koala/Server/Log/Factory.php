<?php
namespace Koala\Server\Log;
class Factory extends \Koala\Server\Factory{
    public static function getServerName($name){
        $server_name = 'Monolog';
        switch($name){
            case 'log':
                if(APPENGINE=='SAE'){
                    if (function_exists('SAELog')) $server_name = 'SAELog' ;
                }elseif(APPENGINE=='BAE'){
                    if (class_exists('BaeLog')) $server_name = 'BaeLog' ;
                }else{
                    if (class_exists('Log')) $server_name = 'LAELog' ;
                }
            case 'monolog':
            default:
                $server_name = 'Monolog' ;
            break;
        }
        return self::getRealName('Log',$server_name);
    }
}