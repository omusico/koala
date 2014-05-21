<?php
namespace Koala\Server\Channel;
class Factory extends \Koala\Server\Factory{
    public static function getServerName($name){
        $server_name = 'LAEChannel';
        switch($name){
            case 'channel':
                if(APPENGINE=='SAE'){
                    if (function_exists('SAEChannel')) $server_name = 'SAEChannel' ;
                }elseif(APPENGINE=='BAE'){
                    if (class_exists('BaeChannel')) $server_name = 'BaeChannel' ;
                }else{
                    if (class_exists('Channel')) $server_name = 'LAEChannel' ;
                }
            break;
        }
         return self::getRealName('Channel',$server_name);
    }
}