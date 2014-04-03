<?php
namespace Server;
class Channel\Factory extends Factory{
    public static function getServerName($type){
        switch($type){
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
?>