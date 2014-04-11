<?php
namespace Server\KVDB;
class Factory extends \Server\Factory{
    public static function getServerName($name){
        $server_name = 'LAEKVDB';
        switch($name){
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