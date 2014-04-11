<?php
namespace Server\Controller;
class Factory extends \Server\Factory{
    public static function getServerName($type){
        $server_name = 'Controller';
        switch($type){
            case 'controller':
                $server_name = 'Controller';
            break;
        }
         return self::getRealName('Controller',$server_name);
    }
}