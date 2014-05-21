<?php
namespace Koala\Server\Storage;
class Factory extends \Koala\Server\Factory{
    public static function getServerName($name){
        $server_name = 'LAEStorage';
        switch($name){
            case 'storage':
                if(APPENGINE=='SAE'){
                    if (function_exists('SAEStorage')) $server_name = 'SAEStorage' ;
                }elseif(APPENGINE=='BAE'){
                    if (class_exists('BaeStorage')) $server_name = 'BaeStorage' ;
                }else{
                    if (class_exists('Storage')) $server_name = 'LAEStorage' ;
                }
            break;
        }
        return self::getRealName('Storage',$server_name);
    }
}