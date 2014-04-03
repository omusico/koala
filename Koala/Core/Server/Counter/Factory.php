<?php
namespace Server\Counter;
class Factory extends \Server\Factory{
    public static function getServerName($type){
        $server_name = 'LAECounter';
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