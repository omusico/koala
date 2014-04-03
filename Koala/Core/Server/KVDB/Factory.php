<?php
namespace Server;
class KVDB\Factory extends Factory{
    public static function getServerName($type){
        switch($type){
            case 'kvdb':
                if(APPENGINE=='SAE'){
                    if (function_exists('SAEKVDB')) $server_name = 'SAEKVDB' ;
                }elseif(APPENGINE=='BAE'){
                    if (class_exists('BaeKVDB')) $server_name = 'BaeKVDB' ;
                }else{
                    if (class_exists('KVDB')) $server_name = 'LAEKVDB' ;
                }
            break;
        }
        return self::getRealName('KVDB',$server_name);
    }
}
?>