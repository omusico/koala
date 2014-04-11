<?php
namespace Server\Controller;
class Factory extends \Server\Factory{
    public static function getServerName($name){
        $server_name = 'Controller';
        switch($name){
            case 'controller':
                $server_name = 'Controller';
            break;
        }
         return self::getRealName('Controller',$server_name);
    }
}