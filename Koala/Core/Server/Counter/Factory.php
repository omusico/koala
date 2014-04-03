<?php
namespace Server;
class Counter\Factory extends Factory{
    public static function getServerName($type){
        switch($type){
            case 'counter':
                if(APPENGINE=='SAE'){
                    if (function_exists('SAECounter')) $server_name = 'SAECounter' ;
                }elseif(APPENGINE=='BAE'){
                    if (class_exists('BaeCounter')) $server_name = 'BaeCounter' ;
                }else{
                    if (class_exists('Counter')) $server_name = 'LAECounter' ;
                }
            break;
        }
         return self::getRealName('Counter',$server_name);
    }
}
?>